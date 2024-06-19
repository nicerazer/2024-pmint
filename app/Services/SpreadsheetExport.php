<?php

namespace App\Services;

use App\Helpers\ReportQueries;
use App\Models\StaffSection;
use App\Models\StaffUnit;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Chart\Legend as ChartLegend;
use PhpOffice\PhpSpreadsheet\Chart\Renderer\MtJpGraphRenderer;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\Settings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Throwable;

class SpreadsheetExport {
    private Spreadsheet $spreadsheet;
    private Worksheet $worksheet;
    private Xlsx $writer;
    private static $months_abbrs = ['Jan','Feb','Mac','Apr','Mei','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    private array $cell_name_labels = [];
    private array $cell_name_values = [];
    private string $temp_file_name = '';
    private string $real_file_name = '';

    public function __construct() {
        $this->spreadsheet = new Spreadsheet();
    }

    private function setupForWriting() {
        if (! in_array('sheet-tmp', Storage::directories()))
            Storage::makeDirectory('sheet-tmp');

        // $this->writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($this->spreadsheet, "Xlsx");
        $this->writer = new Xlsx($this->spreadsheet);
        $this->writer->setIncludeCharts(true);
        // $this->writer->setPreCalculateFormulas(false);
    }

    private function writeSheet() {
        // $temp_path = Storage::path('sheet-tmp\\helloworld.xlsx');
        $filename = tempnam(Storage::path('sheet-tmp'), '');
        // $filename = now()->timestamp . tempnam(Storage::path('sheet-tmp'), '');
        $this->temp_file_name = $filename;
        unlink($filename);
        $this->writer->save($filename);
    }

    public function download() : \Symfony\Component\HttpFoundation\StreamedResponse {
        $path = 'sheet-tmp\\'.basename($this->temp_file_name);
        // Log::debug($path . '\n' . $this->real_file_name);
        return Storage::download($path, $this->real_file_name);
    }

    public function annualStaff($date_cursor, $staff_id): \Symfony\Component\HttpFoundation\StreamedResponse {

        $staff = User::find($staff_id);
        $staff_name = $staff->name;
        $this->real_file_name = 'laporan-tahunan-staff-' . substr($staff->ic, -4) . '-' . $date_cursor->year . '.xlsx';

        $data =  ReportQueries::monthlyStaff($date_cursor, $staff_id);
        $data = collect($data)->map(fn($v) => [$v["month"], strval($v["count"])]);
        $data->prepend(['', $staff_name]);
        Log::debug($data);

        $this->worksheet = $this->spreadsheet->getActiveSheet();
        $this->worksheet->fromArray($data->toArray());

        self::charting(['B1'], ['A2', 'A13'], [['B2', 'B13']], 'Laporan untuk staff ' . $staff_name . ' pada ' . $date_cursor->year, ['A15', 'P38']);
        // $helper->write($this->spreadsheet, __FILE__, ['Xlsx'], true);

        self::setupForWriting();
        self::writeSheet();
        return self::download();

        // $path = 'sheet-tmp\\'.basename($this->temp_file_name);
        // return [$path, $this->real_file_name];
    }

    public function annualUnit($date_cursor, $staff_unit_id) : \Symfony\Component\HttpFoundation\StreamedResponse {

        $temp_q = ReportQueries::monthlyUnit(now(), $staff_unit_id);
        $data = [];

        $staffs = $temp_q["labels"];
        array_unshift($staffs, "");

        $data = $temp_q["data"]->map(function (array $item) {
          return array_values(array_pad($item, 4, 0));
        });
        $data = $data->prepend($staffs);
        // DATA READY

        $this->worksheet = $this->spreadsheet->getActiveSheet();
        $this->worksheet->fromArray($data->toArray());
        self::cellPrep($data);
        self::charting($this->cell_name_labels, ['A2', 'A13'], $this->cell_name_values, 'Laporan untuk unit ' . StaffUnit::find($staff_unit_id)->name . ' pada ' . $date_cursor->year , ['A15', 'P38']);
        self::setupForWriting();
        self::writeSheet();
        return self::download();
    }

    public function annualSection($date_cursor, int $staff_section_id) : \Symfony\Component\HttpFoundation\StreamedResponse {
        $temp_q = ReportQueries::monthlySection($date_cursor, $staff_section_id);
        $data = [];
        $temp_q;
        $labels = $temp_q["labels"];
        array_unshift($labels, "");

        $data = $temp_q["data"]->map(function (array $item) {
          return array_values(array_pad($item, 4, 0));
        });
        $data = $data->prepend($labels);
        // DATA READY

        $this->worksheet = $this->spreadsheet->getActiveSheet();
        $this->worksheet->fromArray($data->toArray());
        self::cellPrep($data);
        self::charting($this->cell_name_labels, ['A2', 'A13'], $this->cell_name_values, 'Laporan untuk bahagian ' . StaffSection::find($staff_section_id)->name . ' pada ' . $date_cursor->year, ['A15', 'P38']);
        self::setupForWriting();
        self::writeSheet();
        return self::download();
    }

    public function annualOverall($date_cursor) : \Symfony\Component\HttpFoundation\StreamedResponse {
        $temp_q = ReportQueries::monthlyOverall($date_cursor);
        $data = [];
        $temp_q;
        $labels = $temp_q["labels"];
        array_unshift($labels, "");

        $data = $temp_q["data"]->map(function (array $item) {
          return array_values(array_pad($item, 4, 0));
        });
        $data = $data->prepend($labels);
        // DATA READY

        $this->worksheet = $this->spreadsheet->getActiveSheet();
        $this->worksheet->fromArray($data->toArray());
        self::cellPrep($data);
        self::charting($this->cell_name_labels, ['A2', 'A13'], $this->cell_name_values, 'Laporan tahunan seluruh bahagian pada ' . $date_cursor->year, ['A15', 'P38']);
        self::setupForWriting();
        self::writeSheet();
        return self::download();
    }

    /**
     * Prepare cell
     *
     * @param Illuminate\Support\Collection $data
     * @return void
     */
    private function cellPrep($data) {
        for($i = 1, $cell = 'B'; $i < count($data[0]); ++$i, ++$cell) {
            $this->cell_name_labels[] = $cell . '1';
        }

        for($i = 1, $cell = 'B'; $i < count($data[0]); ++$i, ++$cell) {
            $this->cell_name_values[] = [$cell . '2', $cell . '13'];
        }
    }

    /**
     * Undocumented function
     *
     * @param array $datalabel_cell_names
     * @param array $x_labels_cell_names
     * - From and to cell, ['A1','A12']
     * @return void
     */
    private function charting(array $datalabel_cell_names, array $x_labels_cell_names, array $data_series_values, string $title, array $chart_cell_pos) {

        // Set the Labels for each data series we want to plot
        //     Datatype
        //     Cell reference for data
        //     Format Code
        //     Number of datapoints in series
        //     Data values
        //     Data Marker
        // $datalabel_cell_names[0];
        $dataSeriesLabels = [];
        foreach($datalabel_cell_names as $dcn) {
            $split = preg_split("/(?<=\\D)(?=\\d)|(?<=\\d)(?=\\D)/", $dcn);
            array_push($dataSeriesLabels,
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$'.$split[0].'$'.$split[1], null, 1)
            );
        }

        // Set the X-Axis Labels
        //     Datatype
        //     Cell reference for data
        //     Format Code
        //     Number of datapoints in series
        //     Data values
        //     Data Marker
        $split_first = preg_split("/(?<=\\D)(?=\\d)|(?<=\\d)(?=\\D)/", $x_labels_cell_names[0]);
        $split_second = preg_split("/(?<=\\D)(?=\\d)|(?<=\\d)(?=\\D)/", $x_labels_cell_names[1]);
        $xAxisTickValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$'.$split_first[0].'$'.$split_first[1].':$'.$split_second[0].'$'.$split_second[1], null, 12), // Jan to Dec
        ];

        // Lay out data
        $dataSeriesValues = [];
        foreach($data_series_values as $dsv) {
            $split_first = preg_split("/(?<=\\D)(?=\\d)|(?<=\\d)(?=\\D)/", $dsv[0]);
            $split_second = preg_split("/(?<=\\D)(?=\\d)|(?<=\\d)(?=\\D)/", $dsv[1]);
            array_push($dataSeriesValues,
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$'.$split_first[0].'$'.$split_first[1].':$'.$split_second[0].'$'.$split_second[1], null, 12)
            );
        }

        $series = new DataSeries(
            DataSeries::TYPE_BARCHART, // plotType
            DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues) - 1), // plotOrder
            $dataSeriesLabels, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues        // plotValues
        );
        $series->setPlotDirection(DataSeries::DIRECTION_COL);
        $plotArea = new PlotArea(null, [$series]);
        $legend = new ChartLegend(ChartLegend::POSITION_BOTTOM, null, false);
        $title = new Title($title);
        $yAxisLabel = new Title('Worklog count');
        $chart = new Chart(
            'Worklog Chart', // name
            $title, // title
            $legend, // legend
            $plotArea, // plotArea
            true, // plotVisibleOnly
            DataSeries::EMPTY_AS_GAP, // displayBlanksAs
            null, // xAxisLabel
            $yAxisLabel  // yAxisLabel
        );
        $chart->setTopLeftPosition($chart_cell_pos[0]);
        $chart->setBottomRightPosition($chart_cell_pos[1]);
        $this->worksheet->addChart($chart);

        // $helper = new Sample();

        // $helper->renderChart($chart, __FILE__);
    }

    private function renderChart(Chart $chart, string $fileName, ?Spreadsheet $spreadsheet = null): void
    {
        Settings::setChartRenderer(MtJpGraphRenderer::class);

        $fileName = $this->getFilename($fileName, 'png');
        $title = $chart->getTitle();
        $caption = null;
        if ($title !== null) {
            $calculatedTitle = $title->getCalculatedTitle($spreadsheet);
            if ($calculatedTitle !== null) {
                $caption = $title->getCaption();
                $title->setCaption($calculatedTitle);
            }
        }

        try {
            $chart->render($fileName);
            Log::debug('Rendered image: ' . $fileName);
            $imageData = @file_get_contents($fileName);
            if ($imageData !== false) {
                echo '<div><img src="data:image/gif;base64,' . base64_encode($imageData) . '" /></div>';
            } else {
                Log::debug('Unable to open chart' . PHP_EOL);
            }
        } catch (Throwable $e) {
            Log::debug('Error rendering chart: ' . $e->getMessage() . PHP_EOL);
        }
        // if (isset($title, $caption)) {
        //     $title->setCaption($caption);
        // }
        Settings::unsetChartRenderer();
    }

    public function getFilename(string $filename, string $extension = 'xlsx'): string
    {
        return '';
        // $originalExtension = pathinfo($filename, PATHINFO_EXTENSION);

        // return $this->getTemporaryFolder() . '/' . str_replace('.' . $originalExtension, '.' . $extension, basename($filename));
    }
}
/** Sample data for staff monthly
    * $data = [
    *     ['', 'Staff A'],
    *     ['Jan', '0'],
    *     ['Feb', '0'],
    *     ['Mar', '20'],
    *     ['Apr', '0'],
    *     ['Mei', '0'],
    *     ['Jun', '40'],
    *     ['Jul', '0'],
    *     ['Ogos', '50'],
    *     ['Sept', '0'],
    *     ['Oct', '20'],
    *     ['Nov', '0'],
    *     ['Dec', '0'],
        // ];

 */

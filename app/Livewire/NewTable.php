<?php

namespace App\Livewire;

use App\Helpers\WorkLogCodes;
use App\Models\User;
use App\Models\WorkLog;
use App\Models\WorkScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Enumerable;
use RamonRietdijk\LivewireTables\Actions\Action;
use RamonRietdijk\LivewireTables\Columns\BooleanColumn;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Columns\DateColumn;
use RamonRietdijk\LivewireTables\Columns\ImageColumn;
use RamonRietdijk\LivewireTables\Columns\SelectColumn;
use RamonRietdijk\LivewireTables\Filters\BooleanFilter;
use RamonRietdijk\LivewireTables\Filters\DateFilter;
use RamonRietdijk\LivewireTables\Filters\SelectFilter;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class NewTable extends LivewireTable
{
    protected string $model = WorkLog::class;

    protected function columns(): array
    {
        return [
            SelectColumn::make(__('Aktiviti'), function (mixed $value, Model $model): string {
                    return $model->workScopeTitle();
                })
                ->options(
                    WorkScope::query()->get()->pluck('title')->toArray()
                ),
                // ->searchable(),
                // ->searchable(function (Builder $q, mixed $search): void {
                //     $q->where('worklogs.title', )
                // }),,

            Column::make(__('Nota Kerja'), 'description')
                // ->sortable()
                ->searchable(),

            SelectColumn::make(__('Status'), 'status')
                ->options([
                    // -1 => 'Semua',
                    0 => 'Dalam Tindakan',
                    1 => 'Sedang Dinilai',
                    2 => 'Kembali',
                    3 => 'Selesai',
                    4 => 'Batal',
                ])
                ->displayUsing(function (mixed $value, Model $model): string {
                    return WorkLogCodes::TRANSLATION[$value];
                })
                // ->hidden()
                ->searchable(),

            DateColumn::make(__('Jangka Siap'), 'expected_at')
                // ->sortable()
                ->format('j M'),

            // DateColumn::make('expected_at')
            //     ->sortable()
            //     ->format('F jS, Y'),

            // Column::make(function (Model $model): string {
            //     return '<a class="underline" href="#'.$model->getKey().'">Edit</a>';
            // })
            //     ->clickable(false)
            //     ->asHtml(),
        ];
    }

    protected function filters(): array
    {
        return [
            // SelectFilter::make(__('Status'), 'status')
            //     ->options([
            //         -1 => 'Semua',
            //         0 => 'Dalam Tindakan',
            //         1 => 'Sedang Dinilai',
            //         2 => 'Kembali',
            //         3 => 'Selesai',
            //         4 => 'Batal',
            //     ]),
        ];
    //     return [
    //         BooleanFilter::make('published'),

    //         SelectFilter::make('category_id')
    //             ->options(
    //                 Category::query()->get()->pluck('title', 'id')->toArray()
    //             ),

    //         SelectFilter::make('author_id')
    //             ->options(
    //                 User::query()->get()->pluck('name', 'id')->toArray()
    //             ),

    //         DateFilter::make('created_at'),
    //     ];
    }

    // protected function actions(): array
    // {
    //     return [
    //         Action::make(), 'publish_all', function (): void {
    //             Blog::query()->update(['published' => true]);
    //         })->standalone(),

    //         Action::make('publish', function (Enumerable $models): void {
    //             $models->each(function (Blog $blog): void {
    //                 $blog->published = true;
    //                 $blog->save();
    //             });
    //         }),

    //         Action::make('unpublish', function (Enumerable $models): void {
    //             $models->each(function (Blog $blog): void {
    //                 $blog->published = false;
    //                 $blog->save();
    //             });
    //         }),
    //     ];
    // }
}

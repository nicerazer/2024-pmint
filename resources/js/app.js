import "./bootstrap";

import {
    Livewire,
    Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm.js";
import intersect from "@alpinejs/intersect";
import collapse from "@alpinejs/collapse";

import * as FilePond from "filepond";
// TODO: Optimize chart.js
import Chart from "chart.js/auto";

// File pond plugins
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageValidateSize from "filepond-plugin-image-validate-size";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginFileRename from "filepond-plugin-file-rename";

import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";

window.Alpine = Alpine;
window.FilePond = FilePond;
window.Chart = Chart;

Alpine.plugin(intersect);
Alpine.plugin(collapse);
FilePond.registerPlugin(FilePondPluginImagePreview);
FilePond.registerPlugin(FilePondPluginImageValidateSize);
FilePond.registerPlugin(FilePondPluginFileValidateType);
FilePond.registerPlugin(FilePondPluginFileValidateSize);
FilePond.registerPlugin(FilePondPluginFileRename);

Livewire.start();

import './bootstrap';
import Chart from 'chart.js/auto';
//import ChartLabels from 'chartjs-plugin-labels';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import { TreemapController, TreemapElement } from 'chartjs-chart-treemap';
// Register datalabels
Chart.register(ChartDataLabels, TreemapController, TreemapElement);

// Expose globally
window.Chart = Chart;
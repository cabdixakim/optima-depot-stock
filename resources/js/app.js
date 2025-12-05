// resources/js/app.js

import "./bootstrap";

// --- Tabulator (full bundle includes all modules) ---
import "tabulator-tables/dist/css/tabulator_semanticui.min.css";
import { TabulatorFull as Tabulator } from "tabulator-tables";
window.Tabulator = Tabulator;

// --- PDF / XLSX dependencies ---
import { jsPDF } from "jspdf";
import "jspdf-autotable";   // side-effect import: registers itself on jsPDF
import * as XLSX from "xlsx";

// --- expose exactly what Tabulator wants ---
window.jspdf = { jsPDF };   // Tabulator will look for window.jspdf.jsPDF
window.jsPDF = jsPDF;       // optional convenience
window.XLSX = XLSX;         // XLSX export


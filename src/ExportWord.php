<?php

namespace PHPMaker2024\sgq;

use \PhpOffice\PhpWord;
use DiDom\Document;
use DiDom\Element;

/**
 * Class for export to Word by PHPWord
 */
class ExportWord extends AbstractExport
{
    public static $TableStyle = ["borderSize" => 6, "borderColor" => "A9A9A9", "cellMargin" => 60];
    public static $NoBorderTableStyle = ["cellMargin" => 30];
    public static $TableHeaderCellStyle = ["bgColor" => "E4E4E4"];
    public static $TableHeaderFontStyle = ["bold" => true];
    public static $SpaceAfter = ["spaceAfter" => 0];
    public static $TextBreakStyle = ["lineHeight" => 1];
    public static $WidthMultiplier = 0.7; // Page width multipler
    public static $MaxImageWidth = 250; // Max image width
    public static $WordVersion = 12;
    public static $PaperSize = "A4";
    public static $Orientation = "portrait";
    public $FileExtension = "docx";
    public $PhpWord;
    public $Section;
    public $CellWidth = null;
    public $PhpWordTable;
    public $RowType;

    // Constructor
    public function __construct($table = null)
    {
        parent::__construct($table);
        $this->PhpWord = new PhpWord\PhpWord();
        if ($this->Table) { // Note: Set paper size first
            $this->PhpWord->getCompatibility()->setOoxmlVersion($this->Table->ExportWordVersion);
            $this->Section = $this->PhpWord->createSection([
                "paperSize" => $this->Table->ExportWordPageSize,
                "orientation" => $this->Table->ExportWordPageOrientation
            ]);
            $this->CellWidth = $this->Table->ExportWordColumnWidth;
        } else {
            $this->PhpWord->getCompatibility()->setOoxmlVersion(self::$WordVersion);
            $this->Section = $this->PhpWord->createSection([
                "paperSize" => self::$PageSize,
                "orientation" => self::$Orientation
            ]);
        }
        $this->PhpWord->addTableStyle("phpWord", self::$TableStyle);
        $this->PhpWordTable = $this->Section->addTable("phpWord");
    }

    // Convert to UTF-8
    public function convertToUtf8($value)
    {
        $value = RemoveHtml($value);
        $value = HtmlDecode($value);
        $value = HtmlEncode($value);
        return ConvertToUtf8($value);
    }

    // Table header
    public function exportTableHeader()
    {
    }

    // Field aggregate
    public function exportAggregate($fld, $type)
    {
        if (!$fld->Exportable) {
            return;
        }
        $this->FldCnt++;
        if ($this->Horizontal) {
            global $Language;
            if ($this->FldCnt == 1) {
                $this->PhpWordTable->addRow(0);
            }
            $val = "";
            if (in_array($type, ["TOTAL", "COUNT", "AVERAGE"])) {
                $val = $Language->phrase($type) . ": " . $this->convertToUtf8($fld->exportValue());
            }
            $this->PhpWordTable->addCell($this->CellWidth, ["gridSpan" => 1])->addText(trim($val));
        }
    }

    // Field caption
    public function exportCaption($fld)
    {
        if (!$fld->Exportable) {
            return;
        }
        $this->FldCnt++;
        $this->exportCaptionBy($fld, $this->FldCnt - 1, $this->RowCnt);
    }

    // Field caption by column and row
    public function exportCaptionBy(&$fld, $col, $row)
    {
        if ($col == 0) {
            $this->PhpWordTable->addRow(0);
        }
        $val = $this->convertToUtf8($fld->exportCaption());
        $this->PhpWordTable->addCell($this->CellWidth, ["gridSpan" => 1, "bgColor" => "E4E4E4"])->addText(trim($val), ["bold" => true]); // Customize table header cell styles here
    }

    // Field value by column and row
    public function exportValueBy(&$fld, $col, $row)
    {
        if ($col == 0) {
            $this->PhpWordTable->addRow(0);
        }
        $val = "";
        $maxImageWidth = self::$MaxImageWidth;
        if ($fld->ExportFieldImage && $fld->ViewTag == "IMAGE") { // Image
            $ar = $fld->getTempImage();
            $cell = $this->PhpWordTable->addCell($this->CellWidth);
            foreach ($ar as $imagefn) {
                if (StartsString("data:", $imagefn)) { // Handle base64 image
                    $imagefn = TempImageFromBase64Url($imagefn);
                }
                $fn = realpath($imagefn);
                if ($imagefn != "" && file_exists($fn) && !is_dir($fn)) {
                    $size = @getimagesize($fn);
                    $style = [];
                    if ($maxImageWidth > 0 && @$size[0] > $maxImageWidth) {
                        $style["width"] = $maxImageWidth;
                        $style["height"] = $maxImageWidth / $size[0] * $size[1];
                    }
                    $cell->addImage($fn, $style);
                }
            }
        } elseif ($fld->ExportFieldImage && $fld->ExportHrefValue != "") { // Export custom view tag
            $imagefn = $fld->ExportHrefValue;
            if (StartsString("data:", $imagefn)) { // Handle base64 image
                $imagefn = TempImageFromBase64Url($imagefn);
            }
            $cell = $this->PhpWordTable->addCell($this->CellWidth);
            $fn = realpath($imagefn);
            if ($imagefn != "" && file_exists($fn) && !is_dir($fn)) {
                $size = @getimagesize($fn);
                $style = [];
                if ($maxImageWidth > 0 && @$size[0] > $maxImageWidth) {
                    $style["width"] = $maxImageWidth;
                    $style["height"] = $maxImageWidth / $size[0] * $size[1];
                }
                $cell->addImage($fn, $style);
            }
        } else { // Formatted Text
            $val = $this->convertToUtf8($fld->exportValue());
            // Do not convert as Word only treats the value as text
            // if ($this->RowType > 0) { // Not table header/footer
            //     if (in_array($fld->Type, [4, 5, 6, 14, 131])) { // If float or currency
            //         $val = $this->convertToUtf8($fld->CurrentValue); // Use original value instead of formatted value
            //     }
            // }
            // Note: use both for justify
            $paragraphStyle = preg_match('/\\btext-align:\\s?(left|center|right|justify)\\b/', $fld->CellCssStyle, $m) ? ["alignment" => $m[1] == "justify" ? "both" : $m[1]] : null;
            $this->PhpWordTable->addCell($this->CellWidth, ["gridSpan" => 1])->addText(trim($val), null, $paragraphStyle);
        }
    }

    // Begin a row
    public function beginExportRow($rowCnt = 0)
    {
        $this->RowCnt++;
        $this->FldCnt = 0;
        $this->RowType = $rowCnt;
    }

    // End a row
    public function endExportRow($rowcnt = 0)
    {
    }

    // Empty row
    public function exportEmptyRow()
    {
        $this->RowCnt++;
    }

    // Page break
    public function exportPageBreak()
    {
    }

    // Export a field
    public function exportField($fld)
    {
        if (!$fld->Exportable) {
            return;
        }
        $this->FldCnt++;
        if ($this->Horizontal) {
            $this->exportValueBy($fld, $this->FldCnt - 1, $this->RowCnt);
        } else { // Vertical, export as a row
            $this->RowCnt++;
            $this->exportCaptionBy($fld, 0, $this->RowCnt);
            $this->exportValueBy($fld, 1, $this->RowCnt);
        }
    }

    // Table footer
    public function exportTableFooter()
    {
    }

    // Add HTML tags
    public function exportHeaderAndFooter()
    {
    }

    /**
     * Add image
     *
     * @param string $imagefn Image file
     * @param string $break Break type (before/after)
     * @return void
     */
    public function addImage($imagefn, $break = false)
    {
        $section = $this->Section;
        if (SameText($break, "before")) {
            $section->addPageBreak();
        }
        $size = @getimagesize($imagefn);
        if ($size[0] != 0) {
            $settings = $section->getSettings();
            $factor = PhpWord\Shared\Converter::pixelToTwip(); // 1440/96
            $w = min($size[0], ($settings->getPageSizeW() - $settings->getMarginLeft() - $settings->getMarginRight()) / $factor * self::$WidthMultiplier);
            $h = $w / $size[0] * $size[1];
            $element = $section->addImage($imagefn, ["width" => $w, "height" => $h]);
        } else {
            $element = $section->addImage($imagefn);
        }
        if (SameText($break, "after")) {
            $section->addPageBreak();
        }
        return $element;
    }

    // Load HTML directly (for report)
    public function loadHtml($html)
    {
        $doc = &$this->getDocument($html);
        $this->adjustPageBreak($doc);
        $metas = $doc->find("meta");
        array_walk($metas, fn($el) => $el->remove()); // Remove meta tags
        $tables = $doc->find(self::$Selectors);
        $section = $this->Section;
        $break = $this->Table ? $this->Table->ExportPageBreaks : true;
        $cellwidth = $this->Table ? $this->Table->ExportWordColumnWidth : null;
        $div = $doc->find("#ew-filter-list");
        if (count($div) > 0) {
            $classes = $div[0]->parent()->classes();
            if (!$classes->contains("d-none")) {
                $div2 = $doc->find("#ew-current-date");
                if ($div2) {
                    $value = trim($div2[0]->text());
                    $section->addText($value);
                }
                $div2 = $doc->find("#ew-current-filters");
                if ($div2) {
                    $value = trim($div2[0]->text());
                    $section->addText($value);
                }
                $spans = $div[0]->find("span");
                $spancnt = count($spans);
                for ($i = 0; $i < $spancnt; $i++) {
                    $span = $spans[$i];
                    $class = $span->getAttribute("class") ?? "";
                    if ($class == "ew-filter-caption") {
                        $caption = trim($span->text());
                        $i++;
                        $span = $spans[$i];
                        $class = $span->getAttribute("class") ?? "";
                        if ($class == "ew-filter-value") {
                            $value = trim($span->text());
                            $section->addText($caption . ": " . $value);
                        }
                    }
                }
            }
        }
        $this->PhpWord->addTableStyle("phpWord", self::$TableStyle);
        $this->PhpWord->addTableStyle("phpWordNoBorder", self::$NoBorderTableStyle);
        $n = 0;
        foreach ($tables as $table) {
            $n++;
            $classes = $table->classes();
            $isChart = $classes->contains("ew-chart");
            $isTable = $classes->contains("ew-table");
            // Add page break
            if ($isChart && $break && $classes->contains("break-before-page")) { // Chart (before)
                $section->addPageBreak();
            }
            if ($isTable) {
                $noBorder = $classes->contains("no-border");
                $tbl = $section->addTable($noBorder ? "phpWordNoBorder" : "phpWord");
                $rows = $table->find("tr");
                foreach ($rows as $row) {
                    if (!($row->parent()->tagName() == "table" && $row->parent()->getAttribute("class") == "ew-table-header-btn")) {
                        $cells = $row->children();
                        $tbl->addRow(0);
                        foreach ($cells as $cell) {
                            if (!$cell->isElementNode() || $cell->tagName() != "td" && $cell->tagName() != "th") {
                                continue;
                            }
                            $k = 1;
                            if ($cell->hasAttribute("colspan")) {
                                $k = intval($cell->getAttribute("colspan"));
                            }
                            $images = $cell->find("img");
                            if (count($images) > 0) { // Image
                                $cell = $tbl->addCell($cellwidth);
                                foreach ($images as $image) {
                                    $imagefn = $image->getAttribute("src") ?? "";
                                    if (StartsString("data:", $imagefn)) { // Handle base64 image
                                        $imagefn = TempImageFromBase64Url($imagefn);
                                    }
                                    if (file_exists($imagefn)) {
                                        $this->addImage($imagefn);
                                    }
                                }
                            } else { // Text
                                $text = htmlspecialchars(trim($cell->text()), ENT_NOQUOTES);
                                $text = preg_replace(['/[\r\n\t]+:/', '/[\r\n\t]+\(/'], [":", " ("], trim($text)); // Replace extra whitespaces before ":" and "("
                                if ($row->parent()->tagName() == "thead") { // Caption
                                    $cellStyle = self::$TableHeaderCellStyle;
                                    $cellStyle["gridSpan"] = $k;
                                    $tbl->addCell($cellwidth, $cellStyle)->addText($text, self::$TableHeaderFontStyle, self::$SpaceAfter); // Customize table header cell styles here
                                } else {
                                    $tbl->addCell($cellwidth, ["gridSpan" => $k])->addText($text, [], self::$SpaceAfter);
                                }
                            }
                        }
                    }
                }
            } else { // div
                $images = $table->find("img");
                if (count($images) > 0) { // Images
                    foreach ($images as $image) {
                        $imagefn = $image->getAttribute("src") ?? "";
                        if (StartsString("data:", $imagefn)) { // Handle base64 image
                            $imagefn = TempImageFromBase64Url($imagefn);
                        }
                        if (file_exists($imagefn)) {
                            $this->addImage($imagefn);
                        }
                    }
                } else { // Text
                    $section->addText(trim($table->text()));
                }
            }

            // Last
            if ($n == count($tables)) {
                break;
            }

            // Add page break
            if ($isChart && $break && $classes->contains("break-after-page")) { // Chart (after)
                $section->addPageBreak();
                continue;
            } elseif ($isTable) { // Table
                $node = $table->closest(".ew-grid");
                if ($node) {
                    $node = $node->nextSibling();
                    while ($node && !$node->isElementNode()) {
                        $node = $node->nextSibling();
                    }
                    if ($node?->isElementNode() && $node->classes()->contains("break-before-page")) {
                        $section->addPageBreak();
                        continue;
                    }
                }
            }

            // Add text break
            $node = $table->nextSibling();
            while ($node && !$node->isElementNode()) {
                $node = $node->nextSibling();
            }
            if ($node && SameText($node->tagName(), "br")) {
                $section->addTextBreak(1, null, self::$TextBreakStyle);
            }
        }
    }

    // Export
    public function export($fileName = "", $output = true, $save = false)
    {
        $writer = PhpWord\IOFactory::createWriter($this->PhpWord, "Word2007");
        if ($save) { // Save to folder
            $file = ExportPath(true) . $this->getSaveFileName();
            @$writer->save($file);
        }
        if ($output) { // Output
            $this->writeHeaders($fileName);
            @$writer->save("php://output");
        }
    }

    // Destructor
    public function __destruct()
    {
    }
}

<?php

namespace RepoEldo\ELD;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ReportViewer
{
    protected $parameters = [];
    protected $group_grand_total = [
        0 => ["amount" => 0],
        1 => ["amount" => 0],
        2 => ["amount" => 0],
        3 => ["amount" => 0],
        4 => ["amount" => 0],
        5 => ["amount" => 0],
        6 => ["amount" => 0],
        7 => ["amount" => 0],
        8 => ["amount" => 0],
        9 => ["amount" => 0],
        10 => ["amount" => 0],
        11 => ["amount" => 0],
        12 => ["amount" => 0],
        13 => ["amount" => 0],
        14 => ["amount" => 0],
        15 => ["amount" => 0],
        16 => ["amount" => 0],
        17 => ["amount" => 0],
        18 => ["amount" => 0],
        19 => ["amount" => 0],
        20 => ["amount" => 0],
    ];


    public function viewReport($report)
    {
        return $this->createPage($report);
    }

    public function addParameter($parameter_name, $parameter_value)
    {
        $this->parameters[$parameter_name] = $parameter_value;
    }



    private function createPage($url)
    {
        $file = File::get("jsonreport/" . $url);
        $json = json_decode($file, true);
        if (isset($json['title'])) {
            $title = $json['title'];
        }

        $header = [];
        if (isset($json['header'])) {
            $header = $json['header'];
        }


        $footer = [];
        if (isset($json['footer'])) {
            $footer = $json['footer'];
        }


        $detail = [];
        if (isset($json['detail'])) {
            $detail = $json['detail'];
        }


        $column_header = [];
        if (isset($json['column-header'])) {
            $column_header = $json['column-header'];
        }




        $title_height = $this->getBandHeight($title);
        $header_height = $this->getBandHeight($header);
        $column_header_height = $this->getBandHeight($column_header);
        $footer_height = $this->getBandHeight($footer);


        $page_top = $title_height + $header_height + $column_header_height;
        $title_top = -$page_top;
        $header_top = $title_top + $title_height;
        $column_header_top = $header_top + $column_header_height;
        $footer_bottom = -$footer_height;
        //dd($title_top);

        $title_content = "";
        foreach ($title as $property) {
            if (isset($property['label'])) {
                $title_content .= $this->createLabel($property['label']);
            }
            if (isset($property['table'])) {
                $title_content .= $this->createTable($property['table']);
            }
            if (isset($property['date'])) {
                $title_content .= $this->createDate($property['date']);
            }
            if (isset($property['img'])) {
                if (extension_loaded('gd')) {
                    $title_content .= $this->createImg($property['img']);
                } else {
                    dd("GD extension is NOT installed.");
                }
            }
            if (isset($property['number'])) {
                $title_content .= $this->createNumber($property['number']);
            }
        }


        $header_content = "";
        foreach ($header as $property) {
            if (isset($property['label'])) {
                $header_content .= $this->createLabel($property['label']);
            }
            if (isset($property['date'])) {
                $header_content .= $this->createDate($property['date']);
            }
            if (isset($property['table'])) {
                $header_content .= $this->createTable($property['table']);
            }
            if (isset($property['number'])) {
                $header_content .= $this->createNumber($property['number']);
            }
        }

        $column_header_content = "";
        foreach ($column_header as $property) {
            if (isset($property['label'])) {
                $column_header_content .= $this->createLabel($property['label']);
            }
            if (isset($property['date'])) {
                $column_header_content .= $this->createDate($property['date']);
            }
            if (isset($property['table'])) {
                $column_header_content .= $this->createTable($property['table']);
            }
            if (isset($property['number'])) {
                $column_header_content .= $this->createNumber($property['number']);
            }
        }

        $footer_content = "";
        foreach ($footer as $property) {
            //dd($property['label']);
            if (isset($property['label'])) {
                $footer_content .= $this->createLabel($property['label']);
            }
            if (isset($property['table'])) {
                $footer_content .= $this->createTable($property['table']);
            }
        }

        $detail_content = "";
        foreach ($detail as $property) {
            if (isset($property['label'])) {
                $detail_content .= $this->createLabel($property['label']);
            }
            if (isset($property['table'])) {
                $detail_content .= $this->createTable($property['table']);
            }
            if (isset($property['group'])) {
                $detail_content .= $this->createGroup($property['group']);
            }
            if (isset($property['date'])) {
                $detail_content .= $this->createDate($property['date']);
            }
            if (isset($property['number'])) {
                $detail_content .= $this->createNumber($property['number']);
            }
        }



        $oriantation = $this->getOriantation($json);
        $paper = $this->getPaper($json);


        ini_set('memory_limit', '512M');
        $pdf = App::make('dompdf.wrapper');
        $page = view('eldo_report::eldo_report', compact('title_top', 'header_top', 'footer_bottom', 'title_height', 'header_height', 'footer_height', 'column_header_height', 'column_header_top', 'page_top', 'title_content', 'header_content', 'footer_content', 'detail_content', 'column_header_content'));
        $pdf->loadHTML($page)->setPaper($paper, $oriantation);
        return $pdf->stream();
    }



    private function createDate($obj)
    {

        $text = "";
        if (isset($obj['text'])) {
            $text = $obj['text'];
            if (count(explode('@_$', $text)) > 1) {
                $text = $this->parameters[explode('@_$', $text)[1]];
            }
        }

        $align = "left";
        if (isset($obj['align'])) {
            $align = $obj['align'];
        }

        $border_top = "0";
        if (isset($obj['border-top'])) {
            $border_top = $obj['border-top'];
        }

        $border_bottom = "0";
        if (isset($obj['border-bottom'])) {
            $border_bottom = $obj['border-bottom'];
        }

        $border_left = "0";
        if (isset($obj['border-left'])) {
            $border_left = $obj['border-left'];
        }

        $border_right = "0";
        if (isset($obj['border-right'])) {
            $border_right = $obj['border-right'];
        }

        $bgcolor = "#ffffff";
        if (isset($obj['bg-color'])) {
            $bgcolor = $obj['bg-color'];
        }


        $color = "#000000";
        if (isset($obj['color'])) {
            $color = $obj['color'];
        }

        $width = "100%";
        if (isset($obj['width'])) {
            $width = $obj['width'];
        }

        $height = "30";
        if (isset($obj['height'])) {
            $height = $obj['height'];
        }

        $position = "";
        if (isset($obj['position'])) {
            $position = $obj['position'];
        }

        $x = "0";
        if (isset($obj['x'])) {
            $x = $obj['x'];
        }

        $y = "0";
        if (isset($obj['y'])) {
            $y = $obj['y'];
        }

        $opacity = "1";
        if (isset($obj['opacity'])) {
            $opacity = $obj['opacity'];
        }

        $border_color = "#000000";
        if (isset($obj['border-color'])) {
            $border_color = $obj['border-color'];
        }

        $padding_top = "0";
        if (isset($obj['padding-top'])) {
            $padding_top = $obj['padding-top'];
        }

        $font_size = "12";
        $font_style = "";
        $font_name = "";
        if (isset($obj['font'])) {

            $font = $obj['font'];
            if (isset($font["size"])) {
                $font_size = $font["size"];
            }
            if (isset($font["style"])) {
                $font_style = $font["style"];
            }
            if (isset($font["name"])) {
                $font_name = $font["name"];
            }
        }


        if (isset($obj['format'])) {

            $format = $obj['format'];

            if ($text == "") {
                $text = Carbon::now()->toDateString();
            }
            $format1 = explode("/", $format);
            $format2 = explode("-", $format);
            $text_format1 = explode("/", $text);
            $text_format2 = explode("-", $text);

            $date_array = ["yyyy", "mm", "dd"];

            if (count($text_format1) == 3) {
                if (strlen($text_format1[0]) == 2) {
                    $date_array[0] = $text_format1[2];
                    $date_array[1] = $text_format1[1];
                    $date_array[2] = $text_format1[0];
                } else if (strlen($text_format1[0]) == 4) {
                    $date_array[0] = $text_format1[0];
                    $date_array[1] = $text_format1[1];
                    $date_array[2] = $text_format1[2];
                }
            } else if (count($text_format2) == 3) {
                if (strlen($text_format2[0]) == 2) {
                    $date_array[0] = $text_format2[2];
                    $date_array[1] = $text_format2[1];
                    $date_array[2] = $text_format2[0];
                } else if (strlen($text_format2[0]) == 4) {
                    $date_array[0] = $text_format2[0];
                    $date_array[1] = $text_format2[1];
                    $date_array[2] = $text_format2[2];
                }
            }



            if (count($format1) == 3) {

                if ($format1[0] == "yyyy" && $format1[1] == "mm" && $format1[2] == "dd") {
                    $text = $date_array[0] . "/" . $date_array[1] . "/" . $date_array[2];
                } else if ($format1[0] == "dd" && $format1[1] == "mm" && $format1[2] == "yyyy") {
                    $text = $date_array[2] . "/" . $date_array[1] . "/" . $date_array[0];
                }
            } else if (count($format2) == 3) {

                if ($format2[0] == "yyyy" && $format2[1] == "mm" && $format2[2] == "dd") {
                    $text = $date_array[0] . "-" . $date_array[1] . "-" . $date_array[2];
                } else if ($format2[0] == "dd" && $format2[1] == "mm" && $format2[2] == "yyyy") {
                    $text = $date_array[2] . "-" . $date_array[1] . "-" . $date_array[0];
                }
            }
        }




        $style = "text-align:" . $align . ";";
        $style .= "border-top:" . $border_top . "px solid " . $border_color . ";";
        $style .= "border-bottom:" . $border_bottom . "px solid " . $border_color . ";";
        $style .= "border-right:" . $border_right . "px solid " . $border_color . ";";
        $style .= "border-left:" . $border_left . "px solid " . $border_color . ";";
        $style .= "background-color:" . $bgcolor . ";";
        $style .= "color:" . $color . ";";
        $style .= "width:" . $width . "px;";
        $style .= "height:" . $height . "px;";
        $style .= "position: " . $position . ";";
        $style .= "top:" . $y . "px;";
        $style .= "left:" . $x . "px;";
        $style .= "opacity:" . $opacity . "";
        $style .= "padding-top:" . $padding_top . "px;";
        $style .= "font-family:" . $font_name . ";";
        $style .= "font-size:" . $font_size . "px;";
        $style .= "font-weight:" . $font_style . ";";


        $label = '<div style="' . $style . '">';
        $label .= $text;
        $label .= '</div>';
        return $label;
    }

    private function createLabel($obj)
    {

        $text = "";
        if (isset($obj['text'])) {
            $text = $obj['text'];
            if (count(explode('@_$', $text)) > 1) {
                $text = $this->parameters[explode('@_$', $text)[1]];
            }
        }

        $align = "left";
        if (isset($obj['align'])) {
            $align = $obj['align'];
        }

        $border_top = "0";
        if (isset($obj['border-top'])) {
            $border_top = $obj['border-top'];
        }

        $border_bottom = "0";
        if (isset($obj['border-bottom'])) {
            $border_bottom = $obj['border-bottom'];
        }

        $border_left = "0";
        if (isset($obj['border-left'])) {
            $border_left = $obj['border-left'];
        }

        $border_right = "0";
        if (isset($obj['border-right'])) {
            $border_right = $obj['border-right'];
        }

        $bgcolor = "#ffffff";
        if (isset($obj['bg-color'])) {
            $bgcolor = $obj['bg-color'];
        }


        $color = "#000000";
        if (isset($obj['color'])) {
            $color = $obj['color'];
        }

        $width = "100%";
        if (isset($obj['width'])) {
            $width = $obj['width'];
        }

        $height = "30";
        if (isset($obj['height'])) {
            $height = $obj['height'];
            if (count(explode('@_$', $height)) > 1) {
                $height = $this->parameters[explode('@_$', $height)[1]];
            }
        }

        $position = "";
        if (isset($obj['position'])) {
            $position = $obj['position'];
        }

        $x = "0";
        if (isset($obj['x'])) {
            $x = $obj['x'];
        }

        $y = "0";
        if (isset($obj['y'])) {
            $y = $obj['y'];
        }

        $opacity = "1";
        if (isset($obj['opacity'])) {
            $opacity = $obj['opacity'];
        }

        $border_color = "#000000";
        if (isset($obj['border-color'])) {
            $border_color = $obj['border-color'];
        }

        $padding_top = "0";
        if (isset($obj['padding-top'])) {
            $padding_top = $obj['padding-top'];
        }

        $font_size = "12";
        $font_style = "";
        $font_name = "";
        if (isset($obj['font'])) {

            $font = $obj['font'];
            if (isset($font["size"])) {
                $font_size = $font["size"];
            }
            if (isset($font["style"])) {
                $font_style = $font["style"];
            }
            if (isset($font["name"])) {
                $font_name = $font["name"];
            }
        }




        $style = "text-align:" . $align . ";";
        $style .= "border-top:" . $border_top . "px solid " . $border_color . ";";
        $style .= "border-bottom:" . $border_bottom . "px solid " . $border_color . ";";
        $style .= "border-right:" . $border_right . "px solid " . $border_color . ";";
        $style .= "border-left:" . $border_left . "px solid " . $border_color . ";";
        $style .= "background-color:" . $bgcolor . ";";
        $style .= "color:" . $color . ";";
        $style .= "width:" . $width . "px;";
        $style .= "height:" . $height . "px;";
        $style .= "position: " . $position . ";";
        $style .= "top:" . $y . "px;";
        $style .= "left:" . $x . "px;";
        $style .= "opacity:" . $opacity . "";
        $style .= "padding-top:" . $padding_top . "px;";
        $style .= "font-family:" . $font_name . ";";
        $style .= "font-size:" . $font_size . "px;";
        $style .= "font-weight:" . $font_style . ";";


        $label = '<div style="' . $style . '">';
        $label .= $text;
        $label .= '</div>';
        return $label;
    }



    private function createLabelArgs($obj, $args)
    {

        $text = "";
        if (isset($obj['text'])) {
            $text = $obj['text'];
            if (count(explode('@_$', $text)) > 1) {
                $text = $this->parameters[explode('@_$', $text)[1]];
            }
        }

        $align = "left";
        if (isset($obj['align'])) {
            $align = $obj['align'];
        }

        $border_top = "0";
        if (isset($obj['border-top'])) {
            $border_top = $obj['border-top'];
        }

        $border_bottom = "0";
        if (isset($obj['border-bottom'])) {
            $border_bottom = $obj['border-bottom'];
        }

        $border_left = "0";
        if (isset($obj['border-left'])) {
            $border_left = $obj['border-left'];
        }

        $border_right = "0";
        if (isset($obj['border-right'])) {
            $border_right = $obj['border-right'];
        }

        $bgcolor = "#ffffff";
        if (isset($obj['bg-color'])) {
            $bgcolor = $obj['bg-color'];
        }


        $color = "#000000";
        if (isset($obj['color'])) {
            $color = $obj['color'];
        }

        $width = "100%";
        if (isset($obj['width'])) {
            $width = $obj['width'];
        }

        $height = "30";
        if (isset($obj['height'])) {
            $height = $obj['height'];
        }

        $position = "";
        if (isset($obj['position'])) {
            $position = $obj['position'];
        }

        $x = "0";
        if (isset($obj['x'])) {
            $x = $obj['x'];
        }

        $y = "0";
        if (isset($obj['y'])) {
            $y = $obj['y'];
        }

        $opacity = "1";
        if (isset($obj['opacity'])) {
            $opacity = $obj['opacity'];
        }

        $border_color = "#000000";
        if (isset($obj['border-color'])) {
            $border_color = $obj['border-color'];
        }

        $padding_top = "0";
        if (isset($obj['padding-top'])) {
            $padding_top = $obj['padding-top'];
        }

        $font_size = "12";
        $font_style = "";
        $font_name = "";
        if (isset($obj['font'])) {

            $font = $obj['font'];
            if (isset($font["size"])) {
                $font_size = $font["size"];
            }
            if (isset($font["style"])) {
                $font_style = $font["style"];
            }
            if (isset($font["name"])) {
                $font_name = $font["name"];
            }
        }


        $style = "text-align:" . $align . ";";
        $style .= "border-top:" . $border_top . "px solid " . $border_color . ";";
        $style .= "border-bottom:" . $border_bottom . "px solid " . $border_color . ";";
        $style .= "border-right:" . $border_right . "px solid " . $border_color . ";";
        $style .= "border-left:" . $border_left . "px solid " . $border_color . ";";
        $style .= "background-color:" . $bgcolor . ";";
        $style .= "color:" . $color . ";";
        $style .= "width:" . $width . "px;";
        $style .= "height:" . $height . "px;";
        $style .= "position: " . $position . ";";
        $style .= "top:" . $y . "px;";
        $style .= "left:" . $x . "px;";
        $style .= "opacity:" . $opacity . "";
        $style .= "padding-top:" . $padding_top . "px;";
        $style .= "font-family:" . $font_name . ";";
        $style .= "font-size:" . $font_size . "px;";
        $style .= "font-weight:" . $font_style . ";";


        $label = '<div style="' . $style . '">';
        $label .= $text . $args;
        $label .= '</div>';
        return $label;
    }



    private function createTable($obj)
    {
        ini_set('max_execution_time', '0'); // for infinite time of execution

        $header = [];
        if (isset($obj['header'])) {
            $header = $obj['header'];
        }

        $body = [];
        if (isset($obj['body'])) {
            $body = $obj['body'];
            if (!is_array($body)) {
                if (count(explode('@_$', $body)) > 1) {
                    $body = $this->parameters[explode('@_$', $body)[1]];
                    $body = json_decode(json_encode($body), true);
                }
            }
        }

        //dd(array_keys($body[0])[0]);





        $width = "100%";
        if (isset($obj['width'])) {
            $width = $obj['width'];
        }

        $height = "30";
        if (isset($obj['height'])) {
            $height = $obj['height'];
        }


        $x = "0";
        if (isset($obj['x'])) {
            $x = $obj['x'];
        }

        $y = "0";
        if (isset($obj['y'])) {
            $y = $obj['y'];
        }


        $margin_top = "0";
        if (isset($obj['margin-top'])) {
            $margin_top = $obj['margin-top'];
        }

        $margin_bottom = "0";
        if (isset($obj['margin-bottom'])) {
            $margin_bottom = $obj['margin-bottom'];
        }

        $font_size = "12";
        $font_style = "";
        $font_name = "";
        if (isset($obj['font'])) {

            $font = $obj['font'];
            if (isset($font["size"])) {
                $font_size = $font["size"];
            }
            if (isset($font["style"])) {
                $font_style = $font["style"];
            }
            if (isset($font["name"])) {
                $font_name = $font["name"];
            }
        }

        $style = "width:" . $width . "px;";
        $style .= "height:" . $height . "px;";
        $style .= "top:" . $y . "px;";
        $style .= "left:" . $x . "px;";
        $style .= "margin-top:" . $margin_top . "px;";
        $style .= "margin-bottom:" . $margin_bottom . "px;";
        $style .= "font-family:" . $font_name . ";";
        $style .= "font-size:" . $font_size . "px;";
        $style .= "font-weight:" . $font_style . ";";


        $sum = "";
        if (isset($obj['sum'])) {
            $sum = $obj['sum'];
        }



        $group_sub_total = array();
        $table = '<table width="100%" style="' . $style . '">';
        $table .= '<thead>';
        $table .= '<tr>';
        for ($i = 0; $i < count($header); $i++) {
            if (isset($header[$i][0]['width'])) {
                $style = 'style=" text-align :' . $header[$i][0]['align'] . ';font-weight:bold;max-width:' . $header[$i][0]['width'] . ';min-width:' . $header[$i][0]['width'] . ';';
            } else {
                $style = 'style=" text-align :' . $header[$i][0]['align'] . ';font-weight:bold;';
            }
            if (isset($header[$i][0]['visible'])) {
                if (!$header[$i][0]['visible']) {
                    $style .= 'display:none;';
                }
            }
            $style .= '"';
            $table .= '<td ' . $style . '>';
            $table .= $header[$i][0]['text'];
            $table .= '</td>';
            array_push($group_sub_total, array("" => 0));
            for ($sum_index = 0; $sum_index < count($sum); $sum_index++) {
                if ($header[$i][0]['text'] == $sum[$sum_index]) {
                    $group_sub_total[$i] = array("sum" => 0);
                }
            }
        }

        $table .= '</tr>';
        $table .= '</thead>';
        $table .= '<tbody>';
        for ($i = 0; $i < count($body); $i++) {
            $row_bg = "white";
            if ($i % 2 == 0) {
                $row_bg = "white";
                //$row_bg = "#f4f4f4";
            }
            $table .= '<tr style="background-color:' . $row_bg . '">';
            for ($i2 = 0; $i2 < count($body[$i]); $i2++) {
                $display = "";
                if (isset($header[$i2][0]['visible'])) {
                    if (!$header[$i2][0]['visible']) {
                        $display .= 'display:none;';
                    }
                }
                if (isset($group_sub_total[$i2]["sum"])) {
                    $table .= '<td style=" text-align :' . $header[$i2][0]['align'] . ';' . $display . '">';
                    $table .= number_format($body[$i][array_keys($body[0])[$i2]], 2);
                    $table .= '</td>';
                    $group_sub_total[$i2]["sum"] += $body[$i][array_keys($body[0])[$i2]];
                    //$group_sub_total[$i2]["sum"] = $group_sub_total[$i2]["sum"];
                } else {
                    $table .= '<td style=" text-align :' . $header[$i2][0]['align'] . ';' . $display . '">';
                    if ($header[$i2][0]['format'] == 'text') {
                        $table .= $body[$i][array_keys($body[0])[$i2]];
                    } else if ($header[$i2][0]['format'] == 'number') {
                        $table .= number_format($body[$i][array_keys($body[0])[$i2]], 2);
                    }
                    $table .= '</td>';
                }
            }
            $table .= '</tr>';
        }
        if ($sum != null) {
            $table .= '<tr>';
            $SUB_TOTAL_TEXT = "Sub Total :";
            for ($i = 0; $i < count($header); $i++) {
                $display = "";
                if (isset($header[$i][0]['visible'])) {
                    if (!$header[$i][0]['visible']) {
                        $display .= 'display:none;';
                    }
                }

                if (array_key_exists("sum", $group_sub_total[$i])) {
                    $table .= '<td style="border:0px solid black;' . $display . '">';
                    $table .= '<table style="width:100%;border:0px;' . $display . '"><tr><td style="border:0px;" colspan="' . count($header) . '">' . $SUB_TOTAL_TEXT . '</td>';
                    $table .= '<td  style="border:0px;text-align:' . $header[$i][0]['align'] . '">' . number_format($group_sub_total[$i]["sum"], 2) . '</td></tr></table>';
                    $this->group_grand_total[$i - 1]["amount"] += $group_sub_total[$i]["sum"];
                    $table .= '</td>';
                    $SUB_TOTAL_TEXT = "";
                } else {
                    $this->group_grand_total[$i - 1]["amount"] = "";
                    $table .= '<td style="border:0px solid black;' . $display . '">';
                    $table .= '<table style="width:100%;border:0px;' . $display . '"><tr><td style="border:0px;"></td>';
                    $table .= '<td></td></tr></table>';
                    $table .= '</td>';
                }
                if ($header[$i][0]['text'] == $sum) {
                    $sum = $i;
                }
            }
            $table .= '</tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';
        return $table;
    }



    private function createImg($obj)
    {

        $url = "";
        if (isset($obj['url'])) {
            $url = $obj['url'];
            if (count(explode('@_$', $url)) > 1) {
                $url = str_replace('/media/', '../storage/app/', $this->parameters[explode('@_$', $url)[1]]);
            } else {
                $url = str_replace('/media/', '../storage/app/', $obj['url']);
            }
        }
        //dd($url);

        $width = "";
        if (isset($obj['width'])) {
            $width = $obj['width'];
        }

        $height = "";
        if (isset($obj['height'])) {
            $height = $obj['height'];
        }

        $x = "";
        if (isset($obj['x'])) {
            $x = $obj['x'];
        }

        $y = "";
        if (isset($obj['y'])) {
            $y = $obj['y'];
        }

        $position = "";
        if (isset($obj['position'])) {
            $position = $obj['position'];
        }

        $style = "width:" . $width . "px;";
        $style .= "height:" . $height . "px;";
        $style .= "top:" . $y . "px;";
        $style .= "left:" . $x . "px;";
        $style .= "position: " . $position . ";";

        $img = '<img src="' . $url . '" style="' . $style . '">';
        //dd($img);
        return $img;
    }


    private function getBandHeight($band)
    {
        foreach ($band as $property) {
            if (isset($property['height'])) {
                return $property['height'];
            }
        }
        return 0;
    }


    private function getOriantation($page)
    {
        $oriantation = "PORTRAIT";
        if (isset($page['oriantation'])) {
            $oriantation = $page['oriantation'];
        }
        return $oriantation;
    }


    private function getPaper($page)
    {
        $paper = "A4";
        if (isset($page['paper'])) {
            $paper = $page['paper'];
        }
        return $paper;
    }


    private function createGroup($obj)
    {

        $header = [];
        if (isset($obj['header'])) {
            $header = $obj['header'];
        }

        $details = [];
        if (isset($obj['detail'])) {
            $details = $obj['detail'];
        }


        $group_content = "";


        $footer = [];
        if (isset($obj['footer'])) {
            $footer = $obj['footer'];
        }




        foreach ($details as $detail) {

            if (isset($detail['table'])) {
                $table = $detail['table'];
                if (isset($table['body'])) {
                    $body = $table['body'];
                    if (count(explode('@_$', $body)) > 1) {
                        $body = $this->parameters[explode('@_$', $body)[1]];
                        $group_data = json_decode(json_encode($body), true);
                        foreach ($group_data as $data) {
                            foreach ($header as $head) {
                                $group_content .=  $this->createLabel($head['label']);
                            }
                            $table_id = 0;
                            foreach ($data as $dd) {
                                $group_content .= "<br>";

                                if (isset($detail['sub-title'])) {
                                    $sub_title = $detail['sub-title'];
                                    if (isset($sub_title['title'])) {
                                        if (is_array($sub_title['title'])) {
                                            if (isset($sub_title['label'])) {
                                                if (count($sub_title['title']) == 1) {
                                                    $array = $this->parameters[explode('@_$', $sub_title['title'][0])[1]];
                                                    if (isset($array[$table_id])) {
                                                        $group_content .=  $this->createLabelArgs($sub_title['label'], $array[$table_id]);
                                                    }
                                                    $table_id += 1;
                                                }
                                            }
                                        } else {
                                            if (isset($sub_title['label'])) {
                                                $group_content .=  $this->createLabelArgs($sub_title['label'], $sub_title['title']);
                                            }
                                        }
                                    } else {
                                        if (isset($sub_title['label'])) {
                                            $group_content .=  $this->createLabel($sub_title['label']);
                                        }
                                    }
                                }


                                $table["body"] = $dd;
                                $group_content .= $this->createTable($table);
                            }
                        }
                    }
                }
            }

            if (isset($detail['grand-total'])) {
                //dd($this->group_grand_total);
                $grand_total = $detail['grand-total'];
                $visible = true;
                if (isset($grand_total['visible'])) {
                    $visible = $grand_total['visible'];
                }
                if ($visible) {

                    if (isset($grand_total['column'])) {

                        $column = $grand_total['column'];

                        $table = '<table><tr>';
                        for ($i = 0; $i < count($column); $i++) {
                            $column_width = '100%';
                            if (isset($column[$i]['width'])) {
                                $column_width = $column[$i]['width'] . 'px';
                            }
                            $text_align = 'left';
                            if (isset($column[$i]['align'])) {
                                $text_align = $column[$i]['align'];
                            }
                            $display = "";
                            if (isset($column[$i]['visible'])) {
                                if (!$column[$i]['visible']) {
                                    $display .= 'display:none;';
                                }
                            }
                            $format = "";
                            if (isset($column[$i]['format'])) {
                                $format = $column[$i]['format'];
                            }
                            $style = "style='min-width:" . $column_width . ";text-align:" . $text_align . ";" . $display . "'";

                            if ($this->group_grand_total[$i]["amount"] >= 0) {
                                if ($format == "text") {
                                    $table .= '<td ' . $style . '>' . $this->group_grand_total[$i]["amount"] . '</td>';
                                } else {
                                    $table .= '<td ' . $style . '>' . number_format($this->group_grand_total[$i+1]["amount"], 2) . '</td>';
                                }
                            } else {
                                $table .= '<td ' . $style . '>' . $column[$i+1]['text'] . '</td>';
                            }
                        }
                        $table .= '</tr></table>';
                    }
                    $group_content .= $table;
                }
            }
        }

        return $group_content;
    }





    private function createNumber($obj)
    {

        $value = "";
        if (isset($obj['value'])) {
            $value = $obj['value'];
            if (count(explode('@_$', $value)) > 1) {
                $value = $this->parameters[explode('@_$', $value)[1]];
            }
        }

        $align = "left";
        if (isset($obj['align'])) {
            $align = $obj['align'];
        }

        $border_top = "0";
        if (isset($obj['border-top'])) {
            $border_top = $obj['border-top'];
        }

        $border_bottom = "0";
        if (isset($obj['border-bottom'])) {
            $border_bottom = $obj['border-bottom'];
        }

        $border_left = "0";
        if (isset($obj['border-left'])) {
            $border_left = $obj['border-left'];
        }

        $border_right = "0";
        if (isset($obj['border-right'])) {
            $border_right = $obj['border-right'];
        }

        $bgcolor = "#ffffff";
        if (isset($obj['bg-color'])) {
            $bgcolor = $obj['bg-color'];
        }


        $color = "#000000";
        if (isset($obj['color'])) {
            $color = $obj['color'];
        }

        $width = "100%";
        if (isset($obj['width'])) {
            $width = $obj['width'];
        }

        $height = "30";
        if (isset($obj['height'])) {
            $height = $obj['height'];
        }

        $position = "";
        if (isset($obj['position'])) {
            $position = $obj['position'];
        }

        $x = "0";
        if (isset($obj['x'])) {
            $x = $obj['x'];
        }

        $y = "0";
        if (isset($obj['y'])) {
            $y = $obj['y'];
        }

        $opacity = "1";
        if (isset($obj['opacity'])) {
            $opacity = $obj['opacity'];
        }

        $border_color = "#000000";
        if (isset($obj['border-color'])) {
            $border_color = $obj['border-color'];
        }

        $padding_top = "0";
        if (isset($obj['padding-top'])) {
            $padding_top = $obj['padding-top'];
        }

        $font_size = "12";
        $font_style = "";
        $font_name = "";
        if (isset($obj['font'])) {

            $font = $obj['font'];
            if (isset($font["size"])) {
                $font_size = $font["size"];
            }
            if (isset($font["style"])) {
                $font_style = $font["style"];
            }
            if (isset($font["name"])) {
                $font_name = $font["name"];
            }
        }

        if (isset($obj['format'])) {

            $format = $obj['format'];

            if ($value == "") {
                $value = "0";
            }
            $format = explode(".", $format);

            if (count($format) > 1) {
                $value = number_format($value, strlen($format[1]));
            }
        }




        $style = "text-align:" . $align . ";";
        $style .= "border-top:" . $border_top . "px solid " . $border_color . ";";
        $style .= "border-bottom:" . $border_bottom . "px solid " . $border_color . ";";
        $style .= "border-right:" . $border_right . "px solid " . $border_color . ";";
        $style .= "border-left:" . $border_left . "px solid " . $border_color . ";";
        $style .= "background-color:" . $bgcolor . ";";
        $style .= "color:" . $color . ";";
        $style .= "width:" . $width . "px;";
        $style .= "height:" . $height . "px;";
        $style .= "position: " . $position . ";";
        $style .= "top:" . $y . "px;";
        $style .= "left:" . $x . "px;";
        $style .= "opacity:" . $opacity . "";
        $style .= "padding-top:" . $padding_top . "px;";
        $style .= "font-family:" . $font_name . ";";
        $style .= "font-size:" . $font_size . "px;";
        $style .= "font-weight:" . $font_style . ";";


        $label = '<div style="' . $style . '">';
        $label .= $value;
        $label .= '</div>';
        return $label;
    }



    private function createNumberArgs($obj, $value)
    {

        $align = "left";
        if (isset($obj['align'])) {
            $align = $obj['align'];
        }

        $border_top = "0";
        if (isset($obj['border-top'])) {
            $border_top = $obj['border-top'];
        }

        $border_bottom = "0";
        if (isset($obj['border-bottom'])) {
            $border_bottom = $obj['border-bottom'];
        }

        $border_left = "0";
        if (isset($obj['border-left'])) {
            $border_left = $obj['border-left'];
        }

        $border_right = "0";
        if (isset($obj['border-right'])) {
            $border_right = $obj['border-right'];
        }

        $bgcolor = "#ffffff";
        if (isset($obj['bg-color'])) {
            $bgcolor = $obj['bg-color'];
        }


        $color = "#000000";
        if (isset($obj['color'])) {
            $color = $obj['color'];
        }

        $width = "100%";
        if (isset($obj['width'])) {
            $width = $obj['width'];
        }

        $height = "30";
        if (isset($obj['height'])) {
            $height = $obj['height'];
        }

        $position = "";
        if (isset($obj['position'])) {
            $position = $obj['position'];
        }

        $x = "0";
        if (isset($obj['x'])) {
            $x = $obj['x'];
        }

        $y = "0";
        if (isset($obj['y'])) {
            $y = $obj['y'];
        }

        $opacity = "1";
        if (isset($obj['opacity'])) {
            $opacity = $obj['opacity'];
        }

        $border_color = "#000000";
        if (isset($obj['border-color'])) {
            $border_color = $obj['border-color'];
        }

        $padding_top = "0";
        if (isset($obj['padding-top'])) {
            $padding_top = $obj['padding-top'];
        }

        $font_size = "12";
        $font_style = "";
        $font_name = "";
        if (isset($obj['font'])) {

            $font = $obj['font'];
            if (isset($font["size"])) {
                $font_size = $font["size"];
            }
            if (isset($font["style"])) {
                $font_style = $font["style"];
            }
            if (isset($font["name"])) {
                $font_name = $font["name"];
            }
        }

        if (isset($obj['format'])) {

            $format = $obj['format'];

            if ($value == "") {
                $value = "0";
            }
            $format = explode(".", $format);

            if (count($format) > 1) {
                $value = number_format($value, strlen($format[1]));
            }
        }




        $style = "text-align:" . $align . ";";
        $style .= "border-top:" . $border_top . "px solid " . $border_color . ";";
        $style .= "border-bottom:" . $border_bottom . "px solid " . $border_color . ";";
        $style .= "border-right:" . $border_right . "px solid " . $border_color . ";";
        $style .= "border-left:" . $border_left . "px solid " . $border_color . ";";
        $style .= "background-color:" . $bgcolor . ";";
        $style .= "color:" . $color . ";";
        $style .= "width:" . $width . "px;";
        $style .= "height:" . $height . "px;";
        $style .= "position: " . $position . ";";
        $style .= "top:" . $y . "px;";
        $style .= "left:" . $x . "px;";
        $style .= "opacity:" . $opacity . "";
        $style .= "padding-top:" . $padding_top . "px;";
        $style .= "font-family:" . $font_name . ";";
        $style .= "font-size:" . $font_size . "px;";
        $style .= "font-weight:" . $font_style . ";";


        $label = '<div style="' . $style . '">';
        $label .= $value;
        $label .= '</div>';
        return $label;
    }
}

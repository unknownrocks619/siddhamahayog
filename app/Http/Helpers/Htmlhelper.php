<?php 

    function form_input_label($display_label=[],$input=[],$error=[])
    {
        $label = "<label ";
            $label .= $display_label['for'];
        $label .= "class='control-label'>";
        $label .= $display_label['value'];
        $label .= "</label>";

        $label .= "<input type='text' class='form-control' ";
            $label .= " name='" . $input['name'] . "'";


            foreach ($input as $key=>$value)
            {
                $label . $key . "='" . $value . "'";
            }
        $label .= " />";

        return $label;
    }
?>
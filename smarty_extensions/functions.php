<?php
require_once __DIR__ . '/form_functions.php';
use PHPHtmlParser\Dom;

function smarty_block_panel($params,$content,&$smarty,&$repeat){
    if(!$repeat){
        $content = "<div class='panel'>" . $content;
        $content .= '</div>';
        return $content;
    }
}

function smarty_block_table($params,$content,&$smarty,&$repeat){
    if(!$repeat){
        $dom = new Dom;
        $dom->load($content);
        $th_columns = $dom->find('th');
        $heading = isset($params['heading']) ? $params['heading'] : '';
        $table_id = $params['table_id'];
        $module_name = $smarty->getTemplateVars('module_name');
        $table_head = '';
        foreach($th_columns as $th)
            $table_head .= $th->outerHtml;
        $rows = $dom->find('tr');
        $table_body = '';
        foreach($rows as $row){
            $attr =  $row->getAttribute('class');
            $row->setAttribute('class',$attr . ' alt_row row_hover');
            $table_body .= $row->outerHtml;
        }
        $precontent = "
                <div class='panel d-flex align-items-stretch'>
                    <div class='panel-heading'>
                    ${heading}
                    </div>
                    <table class='table tableDnD cms' id='${table_id}'>
                    <thead>
                        <tr class='nodrag nodrop'>
                        ${table_head}
                        </tr>
                    </thead>
                    <tbody>
                        ${table_body}
                    </tbody>
                    </table>
                </div>
    <script>
   var come_from = 'AdminModulesPositions';
   currentIndex = currentIndex + '&configure={$module_name}' // HACK SOLUTION
    </script>

";
        return $precontent;
    }
}
function smarty_function_column_buttons($params,&$smarty){
    $edit_action = $params['edit_action'];
    $delete_action = $params['delete_action'];
    $current = $smarty->getTemplateVars('current');
    $module_name = $smarty->getTemplateVars('module_name');
    $token = $smarty->getTemplateVars('token');
    $other_data = isset($params['other_data']) ? $params['other_data'] : '';
    $result = "
    <td>
                                    <div class='btn-group-action'>
                                        <div class='btn-group pull-right'>
                                            <a class='btn btn-default' 
                                            href='${current}&configure=${module_name}&token=${token}&action=${edit_action}&${other_data}'
                                                title='Edit'>
                                                <i class='icon-edit'></i> Edit
                                            </a>
                                            <button class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
                                                <i class='icon-caret-down'></i>&nbsp;
                                            </button>
                                            <ul class='dropdown-menu'>
                                                <li>
                                                    <a href='${current}&configure=${module_name}&token=${token}&action=${delete_action}&${other_data}'
                                                        title='Delete'>
                                                        <i class='icon-trash'></i> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
</td>
                                
";
    return $result;
}
function smarty_function_column_position($params,&$smarty){
    $position = $params['position'];
    return "
                                <td class='center pointer dragHandle' id='td_438217'>
                                    <div class='dragGroup'>
                                        <div class='positions'>
                                            ${position}
                                        </div>
                                    </div>
                                </td>
";
}

function smarty_block_table_body($params,$content,&$smarty,&$repeat){
    return $content;
}

function smarty_block_table_head($params,$content,&$smarty,&$repeat){
    if(!$repeat){
        return $content;
    }
}


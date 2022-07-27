<div class='attribute' >
<?php      
    foreach($settings as $setting){
    $color = $setting->color;
    }
        
?>

<table id='contacts'>
    <caption style="background-color:<?php esc_html_e($color)?>;color: white; padding-top: 12px; padding-bottom: 12px;">Contact List</caption>
    <tr>
        <?php
            $tableHeader =  array(
                'id'        => 'ID',
                'name'      => 'Name',
                'email'     => 'Email',
                'mobile'    => 'Mobile',
                'company'   => 'Company',
                'title'     => 'Title',
            );

            (array)$column = unserialize(base64_decode($setting->column));
            if(empty($column)){
                $column = array('1');
            }

            $alterHeader = array_diff($tableHeader, (array)$column);
            $lowerCaseColumn = array_map('strtolower', (array)$column);

            foreach($contact_items as $items){
                foreach($lowerCaseColumn as $col){
                    unset($items->$col);
                }
            }
          
            foreach ($alterHeader as $item):?>
                <th style="background-color:<?php esc_html_e($color)?>"><?php esc_html_e($item) ?></th>
            <?php endforeach; ?>  
        
    </tr>
        
    <?php 
        foreach ($contact_items as $item): ?>
            <tr> 
                <?php if(!empty($item->id)){?> 
                    <td>
                        <?php  esc_html_e($item->id) .'</br>'; ?>
                    </td>
                <?php } ?>
                <?php if(!empty($item->name)){?>
                    <td>
                        <?php  esc_html_e($item->name) .'</br>'; ?>
                    </td>
                <?php } ?>
                <?php if(!empty($item->email)){?>
                    <td>
                        <?php  esc_html_e($item->email) .'</br>'; ?>
                    </td>
                <?php } ?>
                <?php if(!empty($item->mobile)){?>
                    <td>
                        <?php  esc_html_e($item->mobile) .'</br>'; ?>
                    </td>
                <?php } ?>
                <?php if(!empty($item->company)){?>
                    <td>
                        <?php   esc_html_e($item->company) .'</br>'; ?>
                    </td>
                <?php } ?>
                <?php if(!empty($item->title)){?>
                    <td>
                        <?php  esc_html_e($item->title)  .'</br>'; ?>
                    </td>
                <?php } ?>
            </tr>
                
        <?php endforeach; ?>
        
        <?php
            /**
             * For pagination
            */
            if($shortcode_id != 'exist'){
                $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                  
                $position = strpos($url , '?');
                if($position === false){
                    $finalurl = $url;
                }else{
                // remove string from the specific postion
                $finalurl = substr($url,0,$position);
                }
                if((int)$page>1){
                    $prev = (float)$page-1;
                    _e('<div class="pagination"><a href = '. $finalurl.'"?pageno='. $prev .'><</a></div>');
                }
                if((int)$page < $number_of_page){
                    $next = (float)$page+1;
                    _e('<div class="pagination"><a href = '. $finalurl.'"?pageno='. $next  .'>></a></div>');  
                }
                for($page = 1; $page<= $number_of_page; $page++) { 
                    if($page == $current_page){
                        _e('<div class="pagination"><a class="active" href = '. $finalurl.'"?pageno=' . $page . '>' . $page . ' </a></div>'); 
                    }
                    else{
                        _e('<div class="pagination"><a class="" href = '. $finalurl.'"?pageno=' . $page . '>' . $page . ' </a></div>'); 
                    }   
                }
          }
        ?>        
</table>
</div>
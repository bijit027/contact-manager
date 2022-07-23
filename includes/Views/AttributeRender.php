<div class='attribute' >
<?php      
    foreach($settings as $setting){
    $color = $setting->color;
    }
        
?>

    <table id='contacts'>
     <caption style="background-color:<?php esc_html_e($color)?>;color: white; padding-top: 12px; padding-bottom: 12px;">Contact List</caption>
        <tr>

          <th style="background-color:<?php esc_html_e($color)?>"><?php esc_html_e('ID','contact-manger') ?></th>
          <th style="background-color:<?php esc_html_e($color)?>"><?php esc_html_e('Name','contact-manger') ?></th>
          <th style="background-color:<?php esc_html_e($color)?>"><?php esc_html_e('Email','contact-manger') ?></th>
          <th style="background-color:<?php esc_html_e($color)?>"><?php esc_html_e('Mobile','contact-manger') ?></th>
          <th style="background-color:<?php esc_html_e($color)?>"><?php esc_html_e('Company','contact-manger') ?></th>
          <th style="background-color:<?php esc_html_e($color)?>"><?php esc_html_e('Title','contact-manger') ?></th>         
        </tr>
        
        <?php foreach ($contact_items as $item): ?>
          <tr>  
            <td>
              <?php  esc_html_e($item->id) .'</br>'; ?>
            </td>
            <td>
              <?php  esc_html_e($item->name) .'</br>'; ?>
            </td>
            <td>
              <?php  esc_html_e($item->email) .'</br>'; ?>
            </td>
            <td>
              <?php  esc_html_e($item->mobile,) .'</br>'; ?>
            </td>
            <td>
              <?php  esc_html_e($item->company) .'</br>'; ?>
            </td>
            <td>
              <?php  esc_html_e($item->title)  .'</br>'; ?>
            </td>
          </tr>
                   
        <?php endforeach; ?>

        <?php
            $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $position = strpos($url , '?page');
            // remove string from the specific postion
            $finalurl = substr($current_url,0,$position);

            if($page>1){
            _e('<div class="pagination"><a href = '. $finalurl.'"?pageno=' . $page-1 . '"><</a></div>');
            }
            if($page != $number_of_page){
              _e('<div class="pagination"><a href = '. $finalurl.'"?pageno=' . $page+1 . '">></a></div>');
              
            }
            for($page = 1; $page<= $number_of_page; $page++) { 
              
            _e('<div class="pagination"><a href = '. $finalurl.'"?pageno=' . $page . '">' . $page . ' </a></div>');    
          }

        ?>

               
        
</table>
</div>
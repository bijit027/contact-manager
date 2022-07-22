<div class='attribute' >

    <table id='contacts'>
     <caption>Contact List</caption>
        <tr>
          <th><?php esc_html_e('ID','contact-manger') ?></th>
          <th><?php esc_html_e('Name','contact-manger') ?></th>
          <th><?php esc_html_e('Email','contact-manger') ?></th>
          <th><?php esc_html_e('Mobile','contact-manger') ?></th>
          <th><?php esc_html_e('Company','contact-manger') ?></th>
          <th><?php esc_html_e('Title','contact-manger') ?></th>         
        </tr>
        
        <?php foreach ($items as $item): ?>
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

               
        
</table>
</div>
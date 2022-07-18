<div class='attribute' >

    <table id='contacts'>
     <caption>Contact List</caption>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Mobile</th>
          <th>Company</th>
          <th>Title</th>         
        </tr>
        
        <?php foreach ($items as $item): ?>
          <tr>  
            <td>
              <?php  esc_html_e($item->id, 'contact-manager') .'</br>'; ?>
            </td>
            <td>
              <?php  esc_html_e($item->name, 'contact-manager') .'</br>'; ?>
            </td>
            <td>
              <?php  esc_html_e($item->email, 'contact-manager') .'</br>'; ?>
            </td>
            <td>
              <?php  esc_html_e($item->mobile, 'contact-manager') .'</br>'; ?>
            </td>
            <td>
              <?php  esc_html_e($item->company, 'contact-manager') .'</br>'; ?>
            </td>
            <td>
              <?php  esc_html_e($item->title, 'contact-manager')  .'</br>'; ?>
            </td>
          </tr>
                   
        <?php endforeach; ?>

               
        
</table>
</div>
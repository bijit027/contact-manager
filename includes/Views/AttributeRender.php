<div class='attribute' >
    <table id='contacts'>
        <caption class="header" style="background-color:<?php esc_html_e($color); ?>;">Contact List</caption>
        <tr>
            <?php foreach ($alterHeader as $item): ?>
                    <th style="background-color:<?php esc_html_e($color); ?>"><?php esc_html_e($item); ?></th>
                <?php endforeach; ?>             
        </tr>
            
        <?php foreach ($contact_items as $item): ?>
                <tr> 
                    <?php if (!empty($item->id)) { ?> 
                        <td>
                            <?php esc_html_e($item->id) . "</br>"; ?>
                        </td>
                    <?php } ?>
                    <?php if (!empty($item->name)) { ?>
                        <td>
                            <?php esc_html_e($item->name) . "</br>"; ?>
                        </td>
                    <?php } ?>
                    <?php if (!empty($item->email)) { ?>
                        <td>
                            <?php esc_html_e($item->email) . "</br>"; ?>
                        </td>
                    <?php } ?>
                    <?php if (!empty($item->mobile)) { ?>
                        <td>
                            <?php esc_html_e($item->mobile) . "</br>"; ?>
                        </td>
                    <?php } ?>
                    <?php if (!empty($item->company)) { ?>
                        <td>
                            <?php esc_html_e($item->company) . "</br>"; ?>
                        </td>
                    <?php } ?>
                    <?php if (!empty($item->title)) { ?>
                        <td>
                            <?php esc_html_e($item->title) . "</br>"; ?>
                        </td>
                    <?php } ?>
                </tr>
                    
            <?php endforeach; ?>              
    </table>
    <div>
   <?php if ($separator != "withId") {
       $content = include CM_CONTACTS_PATH . "/includes/Frontend/Pagination.php";
   } ?>
    </div>
</div>
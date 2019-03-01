<!-- Modal -->
<?php
if( isset($_GET['post_type']) && $_GET['post_type'] == 'shear_post' )
{ ?>
<div class="modal fade" data-keyboard="false" data-backdrop="static" id="free-shears-members" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Free Members</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

      </div>
      <div class="modal-body">
          <table id="free-shears-members-table" class="display" style="width:100%">
             <?php    
             $free_members = new WP_User_Query( 
                                array( 
                                  'role' => 'shears_membership_user',
                                  'meta_key' => 'shears_membership_status',
                                  'meta_value' => '1' 
                                ) 
                              );
             $free_members = (array) $free_members->get_results();                              
              if(count($free_members) > 0)
              {
                $all_member_ids= array();
                foreach ($free_members as $single_member) {  
                  $all_member_ids[] = $single_member->ID;
                }
                $check_all = implode(",",$all_member_ids);
              }
              else
              {
                $check_all == '';
              }
              
             ?>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Check all &nbsp;&nbsp; <input type="checkbox" name="free_members_selection_all" value="<?php echo $check_all; ?>"></th>
                </tr>
                <input type="hidden" name="free_members_selection_all_values" value="<?php echo $check_all; ?>">
            </thead>
            <tbody>
            <?php 
                                        
              if(count($free_members) > 0)
              {
                $all_member_ids= array();
                foreach ($free_members as $single_member) {  
                  $all_member_ids[] = $single_member->ID;
                ?>
                <tr>
                  <td><?php echo $single_member->data->user_email; ?></td>
                  <td><?php echo $single_member->data->user_email; ?></td>
                  <td><input type="checkbox" name="free_members_selection_ids[]" class="checkbox_check" value="<?php echo $single_member->ID; ?>"></td>
                </tr>

          <?php } 
              }
              else
              { ?>
                <tr>
                  <td>Oops</td>
                  <td>There is no member</td>
                  <td></td>
                </tr> 

            <?php }
            ?>
                
            </tbody>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Select Members</th>
                </tr>
            </tfoot>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary free-shears-members-submit">Save changes</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" data-keyboard="false" data-backdrop="static" id="paid-shears-members" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Paid Members</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

      </div>
      <div class="modal-body">
          <table id="paid-shears-members-table" class="display" style="width:100%">
             <?php    
             $paid_members = new WP_User_Query( 
                                array( 
                                  'role' => 'shears_membership_user',
                                  'meta_key' => 'shears_membership_status',
                                  'meta_value' => '2' 
                                ) 
                              );
             $paid_members = (array) $paid_members->get_results();                              
              if(count($paid_members) > 0)
              {
                $all_member_ids_paid= array();
                foreach ($paid_members as $single_member) {  
                  $all_member_ids_paid[] = $single_member->ID;
                }
                $check_all_paid = implode(",",$all_member_ids_paid);
              }
              else{
                $check_all_paid == '';
              }
              
             ?>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Check all &nbsp;&nbsp; <input type="checkbox" name="paid_members_selection_all" value="<?php echo $check_all_paid; ?>"></th>
                </tr>
                <input type="hidden" name="paid_members_selection_all_values" value="<?php echo $check_all_paid; ?>">
            </thead>
            <tbody>
            <?php 
                                        
              if(count($paid_members) > 0)
              {
                $all_member_ids= array();
                foreach ($paid_members as $single_member) {  
                  $all_member_ids[] = $single_member->ID;
                  ?>
                <tr>
                  <td><?php echo $single_member->data->user_email; ?></td>
                  <td><?php echo $single_member->data->user_email; ?></td>
                  <td><input type="checkbox" name="free_members_selection_ids[]" class="checkbox_check" value="<?php echo $single_member->ID; ?>"></td>
                </tr>

          <?php } 
               
                
              }
              else
              { ?>
                <tr>
                  <td>Oops</td>
                  <td>There is no member</td>
                  <td></td>
                </tr> 

            <?php }
            ?>
                
            </tbody>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Select Members</th>
                </tr>
            </tfoot>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary paid-shears-members-submit">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php } ?>
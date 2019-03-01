
jQuery(document).ready(function($){
 
    $(document).on('change', '[name=shear_members_post]', function() {
        var valueSelected = this.value;
       if(valueSelected == '0')
       {    

            shears_options_status = $("#shears_options_status").val(); 
            if( shears_options_status != 'free' )
            {
                $("#shears_members_id").val(0);
                $("#shears_options_status").val("free");
            }
            modal_name = 'free-shears-members';
            table_name = 'free-shears-members-table';
            free_members_selection_all = 'free_members_selection_all';
            free_members_selection_all_values = 'free_members_selection_all_values';
            // show Modal
            modal_table(modal_name,table_name,free_members_selection_all,free_members_selection_all_values);
        }
        else if(valueSelected == '1')
        {
           
            shears_options_status = $("#shears_options_status").val(); 
            if( shears_options_status != 'paid' )
            {
                $("#shears_members_id").val(0);
                $("#shears_options_status").val("paid");
            }
            modal_name = 'paid-shears-members';
            table_name = 'paid-shears-members-table';
            paid_members_selection_all = 'paid_members_selection_all';
            paid_members_selection_all_values = 'paid_members_selection_all_values';
            // show Modal
            modal_table(modal_name,table_name,paid_members_selection_all,paid_members_selection_all_values);
            //alert( 'You selectedd '+ valueSelected);
        }
        else if(valueSelected == '2')
        {
            shears_options_status = $("#shears_options_status").val(); 
            if( shears_options_status != 'both' )
            {
                $("#shears_members_id").val(0);
                $("#shears_options_status").val("both");
            }
            $.ajax({
                type:"POST",
                url: ajaxadmin.ajaxurl,
                data:{ 
                    action: 'both_free_paid_members'
                    },
                success:function(data)
                {
                    console.log(data);
                    var members_ids =  data.toString(',');
                    $("#shears_members_id").val(members_ids);

                },
                error: function(errorThrown)
                {
                    console.log(errorThrown);
                }
            });
        }

    });
    function checking_marks(){
            
            get_checked_member_ids = $('input[name="get_checked_member_ids"]').val();
            if (undefined !== get_checked_member_ids && get_checked_member_ids.length) {
                    if(get_checked_member_ids.length < 1)
                    {
                        checking_check_marks();
                    }
            } 
            else 
            {
                checking_check_marks();
            }
            
    }
    function checking_check_marks()
    {
        checking_check_mark = $("#shears_members_id").val();
        if(checking_check_mark == 0){
            $('.checkbox_check').prop('checked', false);   
        }
    } 
    function modal_table(modal_name,table_name,free_paid_members_selection_all,free_paid_members_selection_all_values)
    {
        //alert(modal_name+" "+table_name);
        $('#'+modal_name).modal('show');
        $( '#'+modal_name ).on('shown.bs.modal', function (e) {
            checked_member_ids = $('input[name="get_checked_member_ids"]').val();
            checked_member_status = $('input[name="get_memebers_status"]').val();
            if ( modal_name.indexOf(checked_member_status) > -1 ) {
              $("#shears_members_id").val(checked_member_ids);
            }
            checking_marks();    
        });

        

        // data tables
        $('#'+table_name).DataTable({
            "pageLength": 10,
            // "scrollY": 200,
            // "scrollX": true,
            // "columnDefs": [{
            //     "targets": '_all',
            //     "createdCell": function (td, cellData, rowData, row, col) {
            //         $(td).css('padding', '20px');

            //     }
            // }],
            "bDestroy": true,
            drawCallback: function()
            {
                $('.paginate_button', this.api().table().container()).on('click', function()
                {
                    checking_marks();

                    if( $('input[name="'+free_paid_members_selection_all+'"]').is(':checked') )
                    {
                        $('.checkbox_check').prop('checked', true);
                        all_members_ids = $('input[name="'+free_paid_members_selection_all_values+'"]').val();
                        $("#shears_members_id").val(all_members_ids);
                    }
                    
                });       
            }

        });
    
    }
    // FREE IDS - 8,6,5,
    // PAID IDS - 7,4,3,2
    // $('#free-shears-members').on('hidden.bs.modal', function () {
    //     $("#shears_members_id").val('0'); 
    // });
 
    $('.checkbox_check').click(function() {
        if ($(this).is(':checked')) {
            checked_num =$(this).val();
            members_ids = $("#shears_members_id").val();
            var array = members_ids.split(',');
            var checking_existing_no = array.indexOf(checked_num);
            if(checking_existing_no == -1)
            {
                $("#shears_members_id").val(checked_num);
                if(members_ids.length > 0)
                {
                    shears_members_id = $("#shears_members_id").val();
                    var trim = members_ids.replace(/(^,)|(,$)/g, "");
                    trim += ","+shears_members_id+",";

                    $("#shears_members_id").val(trim);

                }
            }
         
        }
        else{
            checked_num =$(this).val();
            members_ids = $("#shears_members_id").val();
            var array = members_ids.split(",");
            array.splice($.inArray(checked_num, array),1);
            unchecked_values_result = array.toString();
            $("#shears_members_id").val(unchecked_values_result);

        }
    
    });

    $('input[name="free_members_selection_all"]').change(function() {
        if($(this).is(":checked")) 
        {

            $('.checkbox_check').prop('checked', true);
            all_members_ids = $('input[name="free_members_selection_all_values"]').val();
            $('input[name="free_members_selection_all"]').val(all_members_ids);
        }
        else
        {
            $('.checkbox_check').prop('checked', false);
            $('input[name="free_members_selection_all"]').val(0);
            $("#shears_members_id").val(0);
        }    
    });
    $('input[name="paid_members_selection_all"]').change(function() {
        if($(this).is(":checked")) 
        {

            $('.checkbox_check').prop('checked', true);
            all_members_ids = $('input[name="paid_members_selection_all_values"]').val();
            $('input[name="paid_members_selection_all"]').val(all_members_ids);
        }
        else
        {
            $('.checkbox_check').prop('checked', false);
            $('input[name="paid_members_selection_all"]').val(0);
            $("#shears_members_id").val(0);
        }      
    });
    $('.paid-shears-members-submit').on('click', function()
    {
        if ( $('input[name="paid_members_selection_all"]').is(':checked') )
        {
            checked_num = $('input[name="paid_members_selection_all"]').val();
            $("#shears_members_id").val(checked_num);
        }

        checked_users_already = $(this).closest("div#paid-shears-members").find("input:checkbox.checkbox_check");
        str_values_checked = "";
        checked_users_already.each(function () {
            if( this.checked ){
                sThisVal = $(this).val();
                str_values_checked += sThisVal+",";
            }
        });

        var shears_members_id = $("#shears_members_id").val();
        var shears_members_id_new = shears_members_id.replace(/,\s*$/, "");

        $("#shears_members_id").val(shears_members_id_new);
        var shears_members_id_now = $("#shears_members_id").val();
        
        if(str_values_checked.length > 1)
        {
            var str_values_checked_new = str_values_checked.replace(/,\s*$/, "");
            $("#shears_members_id").val(str_values_checked_new);
        }
        else if(shears_members_id_now.length < 1)
        {
            $("#shears_members_id").val(0);
        }
        
        $('#paid-shears-members').modal('hide');
       
    });

    $('.free-shears-members-submit').on('click', function()
    {
        if ( $('input[name="free_members_selection_all"]').is(':checked') )
        {
            checked_num = $('input[name="free_members_selection_all"]').val();
            $("#shears_members_id").val(checked_num);
        }

        checked_users_already = $(this).closest("div#free-shears-members").find("input:checkbox.checkbox_check");
        str_values_checked = "";
        checked_users_already.each(function () {
            if( this.checked ){
                sThisVal = $(this).val();
                str_values_checked += sThisVal+",";
            }
        });
        
        var shears_members_id = $("#shears_members_id").val();
        var shears_members_id_new = shears_members_id.replace(/,\s*$/, "");
        $("#shears_members_id").val(shears_members_id_new);
        var shears_members_id_now = $("#shears_members_id").val();
        
        if(str_values_checked.length > 1)
        {
            var str_values_checked_new = str_values_checked.replace(/,\s*$/, "");
            $("#shears_members_id").val(str_values_checked_new);
        }
        else if(shears_members_id_now.length < 1)
        {
            $("#shears_members_id").val(0);
        }

        $('#free-shears-members').modal('hide');
     
    });

    $(':button').click(function () {
        var attr = $(this).attr('data-dismiss');
        if (typeof attr !== typeof undefined && attr !== false) {
            //$("#shears_members_id").val('0'); 
        }
    });


});


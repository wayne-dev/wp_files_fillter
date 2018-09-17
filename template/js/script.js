jQuery(function($) {
    var data = {'action': 'wf_get_list_folder', 'node_parent': ''};
    $.post(global_var.ajax_url, data, function(response){
        $('.container-folder .mutliSelect').html(response.content);
    });

    $(".dropdown dt a").on('click', function() {
        $(".dropdown dd ul").slideToggle('fast');
    });
      
    $(".dropdown dd ul li a").on('click', function() {
        $(".dropdown dd ul").hide();
    });
      
    function getSelectedValue(id) {
        return $("#" + id).find("dt a span.value").html();
    }
      
    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
    });
      
    $(document).on('click', '.mutliSelect li input[type="checkbox"]', function() {
        $('.hida').hide();
        var _this = $(this).parent().parent();
        _this.parent().find('ul').remove();
        if(!$(this).hasClass('checked')){
            var parent_node_id = $(this).val();
            _this.parent().find('input[type="checkbox"]').prop('checked', false).removeClass('checked');
            $(this).prop('checked', true);
            $(this).addClass('checked');
            data = {'action': 'wf_get_list_folder', 'node_parent': parent_node_id,};
            $("p.multiSel").attr('data-id', parent_node_id).text(_this.text());
            $.post(global_var.ajax_url, data, function(response){
                _this.append(response.content);
            });   
        } else {
            var change_content = $(this).closest('ul');
            var parent_node_id = change_content.attr('data-id-parent');
            var parent_node_name = change_content.attr('data-name-parent');
            $("p.multiSel").attr('data-id', parent_node_id).text(parent_node_name);
            $(this).prop('checked', false).removeClass('checked');
        }
    });

    $(document).on('click', '.container-folder button', function() {
        var parent_node_id = $(this).closest('.container-folder').find('.multiSel').attr('data-id');
        //console.log(parent_node_id);
        data = {'action': 'wf_get_list_files', 'node_parent': parent_node_id,};
        $.post(global_var.ajax_url, data, function(response){
            $('.container-files').html(response.content);
        });
    });
});
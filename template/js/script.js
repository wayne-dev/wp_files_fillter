jQuery(function($) {
    var data = {'action': 'wf_get_list_folder', 'node_parent': ''};
    $.post(global_var.ajax_url, data, function(response){
        $('.container-folder .mutliSelect').html(response.content);
    });
      
    $(document).on('change', '.container-folder select', function() {
        $(this).parent().nextAll('label').remove();
        if($(this).val() != ''){
            var _this = $(this);
            var _parent = $(this).parent();
            var parent_node_id = $(this).val();
            _parent.addClass('loading');
            data = {'action': 'wf_get_list_folder', 'node_parent': parent_node_id,};
            $(".container-folder button").attr('data-id', parent_node_id);
            $('.container-folder button').prop('disabled', true);
            $.post(global_var.ajax_url, data, function(response){
                _parent.removeClass('loading');
                if(response.content.trim() != ''){
                    console.log(response.content);
                    _parent.parent().append(response.content);
                } else {
                    $('.container-folder button').prop('disabled', false);
                }
            });
        }
    });

    $(document).on('click', '.container-folder button', function() {
        var parent_node_id = $(this).attr('data-id');
        //console.log(parent_node_id);
        data = {'action': 'wf_get_list_files', 'node_parent': parent_node_id,};
        $.post(global_var.ajax_url, data, function(response){
            $('.container-files').html(response.content);
        });
    });
});
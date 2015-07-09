$(document).ready(function(){
    $('#ja_cardsbundle_game_settings_private').on('switchChange.bootstrapSwitch', function(event, state) {
            $("#gamePassword").toggleClass('hidden');
    });
});
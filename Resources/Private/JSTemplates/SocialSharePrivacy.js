jQuery(document).ready(function($){
    if($('#socialshareprivacy').length > 0){
        $('#socialshareprivacy').socialSharePrivacy({
            services : {
                facebook : {
                    perma_option: 'on',
                    dummy_img: '###extPath###Resources/Public/Js/Socialshareprivacy/images/dummy_facebook_en.png'
                },
                twitter : {
                    status : 'on',
                    dummy_img: '###extPath###Resources/Public/Js/Socialshareprivacy/images/dummy_twitter.png'
                },
                gplus : {
                    display_name : 'Google Plus',
                    dummy_img: '###extPath###Resources/Public/Js/Socialshareprivacy/images/dummy_gplus.png'
                }
            }
        });
    }
});
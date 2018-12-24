export default {
    methods: {
        notify: function (type, message) {
            $('#appAlert').removeClass('d-none');
			$('#appAlert').addClass('alert-'+type);
			$('#appAlert').html(message);
			
			
			setTimeout(function() {
				$('#appAlert').addClass('d-none');
				$('#appAlert').removeClass('alert-'+type);
			}, 3000 );
			
        }
    }
}
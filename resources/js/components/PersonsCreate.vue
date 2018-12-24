
<template>
    <div class="col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="card ">
            <div class="card-header">Create new person</div>
            <div class="card-body">
                <form v-on:submit="saveForm()" class="p-3 ">
                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input type="text" v-model="person.first_name" class="d-block form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Last Name</label>
                        <input type="text" v-model="person.last_name" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                       <label class="control-label">Birthday</label>
						<datepicker  format="MMM dd, yyyy" v-model="person.birthday" input-class="form-control form-control-lg"></datepicker>
                     </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-success">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
	import Datepicker from 'vuejs-datepicker';
	import Notification from '../mixins/alert';
	
    export default {
	     mixins: [ Notification ],
		components: {
			Datepicker
		},
        data: function () {
            return {
                person: {
                    first_name: '',
                    last_name: '',
                    birthday: new Date(),
                }
            }
        },
         methods: {
			
            saveForm() {
                event.preventDefault();
                var app = this;
                var newPerson = app.person;
				
                axios.post('/api/person', newPerson)
                    .then(function (resp) {
                        app.$router.push({path: '/'});
						app.notify('success', "<strong>Success!</strong> Person has been successfully added.");
						
                    })
                    .catch(function (resp) {
                        console.log(resp);
						app.notify('danger', "<strong>Error!</strong> Could not create your person.");
                    });
            }
        }
    }
</script>

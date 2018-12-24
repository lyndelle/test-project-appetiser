
<template>
    <div class="col-lg-6">
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="card ">
            <div class="card-header">Edit person</div>
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
                        <button class="btn btn-lg btn-success">Update</button>
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
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.personId = id;
            axios.get('/api/person/' + id)
                .then(function (resp) {
                    app.person = resp.data;
                })
                .catch(function () {
                    alert("Could not load your person")
                });
        },
        data: function () {
            return {
                personId: null,
                person: {
                    first_name: '',
                    last_name: '',
                    birthdat: ''
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newPerson = app.person;
				
                axios.patch('/api/person/' + app.personId, newPerson)
                    .then(function (resp) {
                        app.$router.replace('/');
						app.notify('success', "<strong>Success!</strong> Person has been successfully edited.");
                    })
                    .catch(function (resp) {
                        console.log(resp);
                       app.notify('danger', "<strong>Error!</strong> Could not update person.");
                    });
            }
        }
    }
</script>

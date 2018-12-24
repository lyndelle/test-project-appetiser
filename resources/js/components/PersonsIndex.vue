
<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createPerson'}" class="btn btn-lg btn-success">Create new person</router-link>
        </div>
		
		<div class="row mb-3">
			<div class="col-lg-6">
				<input v-model="filter.name" class=" form-control mb-1 form-control-lg" placeholder="Filter by Name... ">
			</div>
			<div class="col-lg-2">
				<input v-model="filter.age" min="0" type="number" class="mb-1 form-control form-control-lg" placeholder="Filter by Age... ">
			</div>
			<div class="col-lg-2">
				<button  :disabled="filter.name == '' && filter.age == '' ? true : false" class="mb-1 btn btn-block btn-info btn-lg" v-on:click="fetchPersons()" >Filter</button>
			</div>
			<div class="col-lg-2">
				<button :disabled="filter.name == '' && filter.age == '' ? true : false" class="mb-1 btn btn-block btn-warning btn-lg" v-on:click="clearFilter()" >Clear</button>
			</div>
        </div>
		<div class="card mb-2">
            <div class="card-header">Persons</div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Birthday</th>
						<th>Age</th>
						<th>Last Updated</th>
                        <th>Action </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="person, index in persons">
                        <td>{{ person.first_name }} {{ person.last_name }}</td>
                        <td>{{ person.birthday }}</td>
                        <td>{{ getAge(person.birthday) }}</td>
						 <td>{{ person.updated_at }}</td>
                        <td>
                            <router-link :to="{name: 'editPerson', params: {id: person.id}}" class="btn btn-xs btn-default">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteEntry(person.id, index)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
		<pagination 
           :meta_data="meta_data"
            v-on:next="fetchPersons">
        </pagination>
    </div>
	
</template>


<script>
	
	import Pagination from './Pagination.vue';
	import Notification from '../mixins/alert';
	 
    export default {	
		 mixins: [ Notification ],
		components: {
			Pagination
		},
        data: function () {
            return {
                persons: [],
				filter: {
					name: '',
					age: ''
				},
				meta_data: {
					last_page: null,
					current_page: 1,
					prev_page_url: null
				}
            }
        },
        mounted() {
           this.fetchPersons();
		  
        },
        methods: {
			getAge(dateString){
				var today = new Date();
				var birthDate = new Date(dateString);
				var age = today.getFullYear() - birthDate.getFullYear();
				var m = today.getMonth() - birthDate.getMonth();
				if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) 
				{
					age--;
				}
				return age;
			},
			clearFilter() {
				this.filter = {	name: '', age: ''};
				this.fetchPersons();
			},
			fetchPersons(page = 1) {
				var app = this;
				
				axios.get('/api/person', {
						params: {
							page: page,
							name: app.filter.name,
							age: app.filter.age
						}
					})
					.then(function (resp) {
						app.persons = resp.data.data;
						app.meta_data.last_page = resp.data.last_page;
						app.meta_data.current_page = resp.data.current_page;
						app.meta_data.prev_page_url = resp.data.prev_page_url; 
						console.log(app.meta_data);
						
					})
					.catch(function (resp) {
						console.log(resp);
						app.notify('danger', "<strong>Error!</strong> Could not load persons!");
					});
			},
		
		
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/person/' + id)
                        .then(function (resp) {
                            app.persons.splice(index, 1);
							app.notify('success', "<strong>Success!</strong> Person has been successfully deleted.");
                        })
                        .catch(function (resp) {
							app.notify('danger', "<strong>Error!</strong> Could not delete person.");
                          
                        });
                }
            }
        }
    }
</script>

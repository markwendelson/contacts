<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light pbg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="col-sm-4 my-auto mx-auto" v-show="state">
                <div class="card rounded-0 mb-5">
                    <div class="card-header">
                        <h4>Add New Contact</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Firstname</label>
                            <input type="text" class="form-control" v-model="contact.firstname"/>
                        </div>
                        <div class="form-group">
                            <label>Lastname</label>
                            <input type="text" class="form-control" v-model="contact.lastname"/>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" v-model="contact.email"/>
                        </div>
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" class="form-control" v-model="contact.contact_no"/>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm rounded-0" v-on:click="saveContact">Save</button>
                            <button class="btn btn-danger btn-sm rounded-0" v-on:click="cancel">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12" v-show="!state">
                <div class="card rounded-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8 my-auto">
                                <h4>Contact List</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="float-right">
                                    <button class="btn btn-primary btn-sm rounded-0" v-on:click="state=1">Add New Contact</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Firstname</th>
                                <th scope="col">Lastname</th>
                                <th scope="col">Email</th>
                                <th scope="col">Contact Number</th>
                                <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                        <th scope="row">{{ $contact->id }}</th>
                                        <td>{{ $contact->firstname }}</td>
                                        <td>{{ $contact->lastname }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->contact_no }}</td>
                                        <td>
                                        <div>
                                            <button class="btn btn-success btn-sm rounded-0" v-on:click="viewContact({{ $contact->id }})">View</button>
                                            <button class="btn btn-primary btn-sm rounded-0" v-on:click="editContact({{ $contact->id }})">Edit</button>
                                            <button class="btn btn-danger btn-sm rounded-0" v-on:click="removeContact({{ $contact->id }})">Delete</button>
                                        </div>
                                        </td>
                                    </tr>    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="footer ml-2">
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        new Vue({
            el:"#app",
            data() {
                return {
                    contact: {},
                    state: 0
                }
            },
            methods: {
                saveContact() {
                    let route = `{{ route('contact.store') }}`
                    let params = {
                        firstname: this.contact.firstname,
                        lastname: this.contact.lastname,
                        email: this.contact.email,
                        contact_no: this.contact.contact_no
                    }

                    axios.post(route, params)
                    .then((response) => {
                        Swal.fire(
                            'Success',
                            'New contact added',
                            'Successfuly added new contact',
                        ).then(()=>{
                            this.state = 0
                            window.location = "/"
                        })
                    })
                },
                cancel() {
                    this.state = 0
                    this.contact.firstname = ""
                    this.contact.lastname = ""
                    this.contact.email = ""
                    this.contact.contact_no = ""
                },
                removeContact(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            axios.delete('/contact/'+id).then(() => {
                                Swal.fire(
                                'Deleted!',
                                'Record has been deleted.',
                                'success'
                                )
                                .then(() => {
                                    window.location = "/"
                                })
                            })
                        }
                    })

                },
                viewContact(id) {
                    this.state = 1
                    axios.get('/contact/'+id).then((response) => {
                        this.contact.firstname = response.data.firstname
                        this.contact.lastname = response.data.lastname
                        this.contact.email = response.data.email
                        this.contact.contact_no = response.data.contact_no
                    })

                },
                editContact(id) {
                    this.state = 1
                    let app = this
                    axios.get('/contact/'+id).then((response) => {
                        app.contact.firstname = response.data.firstname
                        app.contact.lastname = response.data.lastname
                        app.contact.email = response.data.email
                        app.contact.contact_no = response.data.contact_no
                    })
                }
            },
        })
    </script>
</body>
</html>

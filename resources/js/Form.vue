<template>
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-6">Web Blinders Laravel Form</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="tab-content">
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                <form role="form" id="form" data-action="">
                                    <div class="form-group"> 
                                        <label for="name">
                                            <h6>Name *</h6>
                                        </label> 
                                        <input type="text" v-model="name" minlength="3" maxlength="24" name="name" placeholder="Name" required class="form-control " v-on:change="validateName()" > 
                                        <small v-if="isNameInvalid" class="text-danger">Please enter valid name</small>
                                    </div>
                                    <div class="form-group"> 
                                        <label for="email">
                                            <h6>Email *</h6>
                                        </label> 
                                        <input type="email" v-model="email" name="email" placeholder="Email" required class="form-control " v-on:change="validateEmail()" > 
                                        <small v-if="isEmailInvalid" class="text-danger">Please enter valid email</small>
                                    </div>
                                    <div class="form-group">  
                                        <label for="message">Message</label>
                                        <textarea v-model="message" class="form-control" maxlength="255" id="message" rows="3" placeholder="Enter some message" name="message" v-on:change="validateMessage()" ></textarea>
                                        <small v-if="isMessageInvalid"  class="text-danger">Please enter valid message</small>
                                    </div>
                                    <div class="card-footer"> 
                                        <button v-on:click="submitForm()" type="button" id="submit" class="btn btn-primary btn-block shadow-sm"> Submit Form </button>
                                    </div>
                                </form>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
 
<script>
import Swal from 'sweetalert2'

    export default {
        name: 'Form',
        data() {
            return {
                name: '',
                email: '', 
                message: '',
                isNameInvalid: false,
                isEmailInvalid: false,
                isMessageInvalid: false,
            }
        },
        created() {
            console.log(process.env.BASE_URL)
        },
        methods: {
            validateName() {
                var hasError = false;
                this.name = this.name.trim();

                // validate name
                if(this.name.length > 3 && this.name.length < 24 && /^[a-zA-Z]*$/.test(this.name)) {
                    this.isNameInvalid = false;
                    hasError = true;
                } else {
                    this.isNameInvalid = true;
                }
                return hasError;
            },
            validateEmail() {
                var hasError = false;
                // validate email
                var emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/

                if(emailRegex.test(this.email) && this.email.length > 0) {
                    this.isEmailInvalid = false;
                    hasError = true;
                } else {
                    this.isEmailInvalid = true;
                }
                return hasError;
            },
            validateMessage() {
                var hasError = false;

                // validate message
                if((this.message.length > 0 && this.message.length <= 255) || (this.message.length < 1) ) {
                    this.isMessageInvalid = false;
                    hasError = true;
                } else {
                    this.isMessageInvalid = true;
                }

                return hasError;
            },
            isValidForm() {

                if((this.validateName() == true) && (this.validateEmail() == true) && (this.validateMessage() == true)) {
                    return true;
                } else {
                    return false;
                }
            },
            async submitForm() {
                
                var data = 'asldkflaskjf HELO WORKLDK';

                if(this.isValidForm()) {
                    var data = {
                                name: this.name,
                                email: this.email,
                            }

                    if(this.message.length > 0) {
                        data.message = this.message;
                    }

                    await axios.post('http://127.0.0.1:8000/api/submit/', 
                        data, 
                        {
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        }
                    )
                    .then(res => {
                        console.log(res);

                        Swal.fire({
                            title: 'Success',
                            text: 'Form Data Stored Successfully.',
                            icon: 'success',
                            confirmButtonText: 'Cool'
                        });

                    })
                    .catch(err => {
                        console.log(err);

                        Swal.fire({
                            title: 'Error!',
                            text: 'Error occurred while storing.',
                            icon: 'error',
                            confirmButtonText: 'Cool'
                        });
                    })
                }
            }
        }
    }
</script>

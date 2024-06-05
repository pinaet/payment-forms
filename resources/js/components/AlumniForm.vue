<template>
			<form id="EventForm" class="contact100-form validate-form" method="post">
                <input type="hidden" name="_token"  v-bind:value="csrfToken">
                <input type="hidden" name="alumnus" value="">

				<p class="contact100-form-title">Event Sign up Form</p>

                <p class="label-input100 sub-title">Sign up now for the Alumni Gathering to meet your schoolmates from all Harrow International Schools</p>

                <div class="row">
                    <div class="col-6">
                        <div class="wrap-input100 validate-input" v-bind:class="{ 'alert-validate':checkError('firstname')}" data-validate="Required">
                            <span  class="label-input100" >First Name </span>
                            <input  name="firstname" class="input100" type="text"  v-model="alumnus.firstname" placeholder="Enter First Name" tabindex="1" @change="removeError('firstname')">
                            <span class="focus-input100"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="wrap-input100 validate-input" v-bind:class="{ 'alert-validate':checkError('lastname')}" data-validate="Required">
                            <span class="label-input100">Surname </span>
                            <input name="lastname" class="input100" type="text" v-model="alumnus.lastname" placeholder="Enter Surname" tabindex="2" @change="removeError('lastname')">
                            <span class="focus-input100"></span>
                        </div>
                    </div>
                </div>

				<div class="wrap-input100 validate-input" v-bind:class="{ 'alert-validate':checkError('email')}" data-validate = "Valid email is required: ex@amail.com">
					<span class="label-input100">Email</span>
					<input name="email" class="input100" type="text"  v-model="alumnus.email" placeholder="Enter your email address" tabindex="3" @change="removeError('email')">
					<span class="focus-input100"></span>
				</div>

                <div class="row">
                    <div class="col-6">
                        <div class="wrap-input100 validate-input none-border" v-bind:class="{ 'alert-validate':checkError('country_id')}" data-validate="Required">
                            <span class="label-input100" >Country Phone Code<br> &nbsp;(optional) </span>
                            <select name="country_id" class="form-control t-option" v-model="alumnus.country_id" tabindex="4" @change="removeError('country_id')">
                                <option value="0" >- Please select -</option>
                                <option v-for="country in countries" :key="country.id" :value="country.id">{{'('+country.iso+') +'+country.phonecode}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="wrap-input100 validate-input " v-bind:class="{ 'alert-validate':checkError('phone')}" data-validate="No '-/+' char">
                            <span class="label-input100">Mobile Phone Number<br> &nbsp;(optional) </span>
                            <input name="phone" class="input100" type="number" v-model="alumnus.phone" tooltip="" placeholder="Enter" tabindex="5" @change="removeError('phone')">
                            <span class="focus-input100"></span>
                        </div>
                    </div>
                </div>

				<div class="wrap-input100 validate-input none-border " v-bind:class="{ 'alert-validate':checkError('school_id')}" data-validate="School Name is required">
					<span class="label-input100">Which school did you graduate from?</span>
                    <select name="school_id" class="form-control t-option" v-model="alumnus.school_id" tabindex="6" @change="removeError('school_id')">
                        <option value="0" >- Please select -</option>
                        <option v-for="school in schools" :key="school.id" :value="school.id">{{school.school}}</option>
                    </select>
				</div>

				<div class="wrap-input100 validate-input none-border" v-bind:class="{ 'alert-validate':checkError('graduated_year')}" data-validate="Year of Graduation is required">
					<span class="label-input100">Year of Graduation</span>
                    <select name="graduated_year" class="form-control t-option" v-model="alumnus.graduated_year" tabindex="7" @change="removeError('graduated_year')">
                        <option value="0" >- Please select -</option>
                        <option v-for="year in years" :key="year.id" :value="year.year">{{year.year}}</option>
                    </select>
				</div>

                <p class="label-input100 ioh-title">
                    <img class="ioh-logo" src="images/iohconnect-logo.png">
                    We proudly announce the soon-to-be launched Harrow alumni networking platform - IOH CONNECT.
                    It is an unincorporated members association formed to enable International Old Harrovians (i.e. Old Harrovians of Harrow International Schools),
                    wherever you are in the world, to maintain lifelong connections with the School and with each other. Say yes to this invitation!
                </p>
                <div class="wrap-input100 validate-input none-border" >
                    <input name="ioh_connect" type="checkbox" class="my-check-box" v-model="alumnus.ioh_connect" true-value="1" false-value="0" tabindex="8">
                    <span class="label-input100">Become a member of <b>IOH CONNECT</b></span>
                </div>

				<div class="wrap-input100 validate-input none-border" v-bind:class="{ 'alert-validate':checkError('terms_agreed')}" data-validate = "Required">
                    <input name="terms_agreed" type="checkbox" class="my-check-box" v-model="alumnus.terms_agreed" true-value="1" false-value="0" tabindex="9" @change="removeError('terms_agreed')">
					<span  class="label-input100">I declare that the information given is accurate and complete.</span>
				</div>

                <p class="label-input100 privacy-stmt"><i>For Privacy Statement, please click <u style="color:#A39163"><a href="uploads/5-privacy-statement-eng-for-alumni-io-hconnect.pdf" target="_blank">here</a></u>.</i></p>

                <div v-if="errors.length>0" class="alert alert-danger" style="padding: 20px; text-align:center;">
                    Please correct error(s) above
                </div>

				<div class="container-contact100-form-btn" id="login_btn_box">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<button id="submit_btn" class="contact100-form-btn" v-on:click.prevent="submitForm()" tabindex="10" >
							<span>
								Submit
								<i class="fas fa-long-arrow-alt-right m-l-7"></i>
							</span>
						</button>
					</div>
                </div>

			</form>

</template>

<script>
export default {
    data() {
        return {
            alumnus: '',
            schools: '',
            countries: '',
            startYear: 0,
            years: '',
            errors: '',
        }
    },
    props: [ 'alumnusRaw', 'schoolsRaw', 'countriesRaw', 'startYearRaw', 'csrfToken' ],
    mounted() {
        this.alumnus    = JSON.parse( this.alumnusRaw   )
        this.schools    = JSON.parse( this.schoolsRaw   )
        this.countries  = JSON.parse( this.countriesRaw )
        this.startYear  = parseInt(   this.startYearRaw )

        // gen year
        this.genGradYears()

    },
    methods: {
        genGradYears(){
            var current_year = new Date().getFullYear() //yyyy
            var year_diff    = current_year - this.startYear
            var json_str     = '['
            for( let i=1; i<=year_diff+1; i++ ){
                json_str += '{"id":'+i+',"year":'+(this.startYear + i - 1)+'},'
            }
            json_str = json_str.slice(0, -1);
                json_str += ']'

            this.years       = JSON.parse( json_str )
        },
        submitForm(){
            //validate form and collect errors
            this.errors = this.validateForm()

            //if there is no any error then submit the form
            if( this.errors.length==0 ){
                $( '#submit_btn'     ).attr( 'disabled', true )

                $( '#EventForm'      ).attr( 'action', './alumni/store' )
                $( '#EventForm'      ).attr( 'method', 'post'  )
                $( 'input[name=alumnus'  ).attr( 'value' , JSON.stringify(this.alumnus) )
                $( '#EventForm'      ).submit()
            }
        },
        validateEmail(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        },
        validateForm(){
            var validate = true
            var errors   = []

            if( this.alumnus.firstname == '' ){
                errors.push( { 'id': 'firstname', 'msg': "First Name required"     } )
            }
            if( this.alumnus.lastname == '' ){
                errors.push( { 'id': 'lastname', 'msg': "Surname required"     } )
            }

            validate = this.validateEmail( this.alumnus.email )
            if( validate==false ){
                errors.push( { 'id': 'email', 'msg': "Valid Email required"     } )
            }

            /*
            if( this.alumnus.country_id == 0 ){
                errors.push( { 'id': 'country_id', 'msg': "Country Phone Code required"     } )
            }
            if( this.alumnus.phone == '' ){
                errors.push( { 'id': 'phone', 'msg': "Mobile Phone Number required"     } )
            }
            */
            if( this.alumnus.school_id == 0 ){
                errors.push( { 'id': 'school_id', 'msg': "School required"     } )
            }
            if( this.alumnus.graduated_year == 0 ){
                errors.push( { 'id': 'graduated_year', 'msg': "Year of Graduate required"     } )
            }
            if( this.alumnus.terms_agreed == 0 ){
                errors.push( { 'id': 'terms_agreed', 'msg': "Terms of Agreement required"     } )
            }

            return errors
        },
        checkError( error_id ) {
            if( this.errors.length>0 ){
                var error = this.errors.filter( error => error.id == error_id )
                return error.length > 0
            }
        },
        removeError( error_id ){
            if( this.errors.length>0 ){

                for( let i=0; i<this.errors.length; i++ ){
                    if( this.errors[i].id==error_id ){
                        this.errors.splice( i, 1 );
                        // Find the index position then remove one element from that position
                        return
                    }
                }
            }
        },

    },
    computed: {

    }
}
</script>

<style>
    .t-option {
        font-size: inherit;
    }
    @media (max-width: 576px) {
        .input100{
            font-size: 14px;
        }
        .t-option {
            font-size: 12px;
        }
    }
    .none-border {
        border-bottom: none !important;
    }
    .sub-title{
        text-align: center;
        padding: 10px 5px;
        margin-bottom: 15px;
        font-weight: bold;
    }
    .ioh-title{
        text-align: justify;
        padding: 10px 8px;
        margin-bottom: 15px;
        font-weight: bold;
        border: 1px solid #ddd;
        border-radius: 10px;
    }
    .round-box{
        border: 1px solid #ddd;
        border-radius: 10px;
    }
    .ioh-logo{
        float: left;
        width: 35%;
        padding: 15px;
    }
    .privacy-stmt{
        text-align: center;
        /* padding: 10px 5px; */
        margin-bottom: 15px;
        font-weight: bold;
    }
    .my-check-box{
        width: 24px;
        height: 24px;
        vertical-align: middle;
    }
</style>

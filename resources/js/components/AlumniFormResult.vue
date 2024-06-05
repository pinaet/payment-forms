<template>  
			<form id="EventForm" class="contact100-form validate-form" method="get">
                
				<p class="contact100-form-title" style="margin-bottom: 30px">Thank You!</p>

				<p class="label-input100 sub-title" style="margin-bottom: 0px">Dear {{alumnus.firstname + ' ' + alumnus.lastname}},</p>
                <p class="label-input100 sub-title">You have successfully signed up to the Harrow Alumni Gathering event that will be held on <u>16 January, 2020</u> in Harrow School, London. More information will be sent to your registered email. 
</p>

				<div class="container-contact100-form-btn" id="login_btn_box">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<button class="contact100-form-btn" v-on:click.prevent="submitForm()" tabindex="10">
							<span>
								<i class="fas fa-long-arrow-alt-left m-r-7"></i>
								Go Back
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
    props: [ 'alumnusRaw', 'csrfToken' ],
    mounted() {
        this.alumnus    = JSON.parse( this.alumnusRaw   )


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

            //if there is no any error then submit the form
            if( this.errors.length==0 ){
                $( '#EventForm'      ).attr( 'action', '.' )
                $( '#EventForm'      ).attr( 'method', 'get'  )
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

            if( this.alumnus.country_id == 0 ){
                errors.push( { 'id': 'country_id', 'msg': "Country Phone Code required"     } )
            }
            if( this.alumnus.phone == '' ){
                errors.push( { 'id': 'phone', 'msg': "Mobile Phone Number required"     } )
            }
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
    .none-border {
        border-bottom: none !important;
    }
    .sub-title{
        text-align: left;
        padding: 10px 5px;
        margin-bottom: 15px;
        font-weight: bold;
    }
    .ioh-title{
        /* text-align: center; */
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
    .contact100-form-btn:hover i {
        -webkit-transform: translateX(-10px);
        -moz-transform: translateX(-10px);
        -ms-transform: translateX(-10px);
        -o-transform: translateX(-10px);
        transform: translateX(-10px);
    }
    html { 
        overflow-y: scroll; 
    }
</style>

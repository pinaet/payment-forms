<template>

			<form id="PaymentForm" class="contact100-form validate-form" method="post">
                <input type="hidden" name="_token"  v-bind:value="csrfToken">
                <input type="hidden" name="order" value="">
				<span class="contact100-form-title">
					<img class="logo" :src="imgPath.logo"><br>
					<!-- Payment Gateway -->
				</span>
				<p class="contact100-form-title">Payment</p>

				<div id="customer_name_label" name="customer_name_label" class="wrap-input100 validate-input" v-bind:class="{ 'alert-validate':checkError('contact_name')}" data-validate="Contact name is required">
					<span class="label-input100">Contact Name <span id="info-contact-name" style="color:#0056B3;"><a href="#" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-info-circle"></i></a></span></span>
					<input class="input100" type="text" id="customer_name" name="customer_name" v-model="schoolFee.contact_name" placeholder="Enter full contact name" tabindex="1" @change="removeError('contact_name')">
					<span class="focus-input100"></span>
				</div>

				<div id="customer_phone_label" name="customer_phone_label" class="wrap-input100 validate-input" v-bind:class="{ 'alert-validate':checkError('phone')}" data-validate = "No '-/+' CHAR">
					<span class="label-input100">Tel / Mobile No.</span>
					<input class="input100" type="number" id="customer_phone" name="customer_phone" v-model="schoolFee.phone" placeholder="Enter your telephone number" tabindex="2" @change="removeError('phone')">
					<span class="focus-input100"></span>
				</div>

				<div id="customer_email_label" name="customer_email_label" class="wrap-input100 validate-input" v-bind:class="{ 'alert-validate':checkError('email')}" data-validate = "Valid email is required: ex@amail.com">
					<span class="label-input100">Email <i>(the same as Parent Portal)</i></span>
					<input class="input100" type="text" id="customer_email" name="customer_email" v-model="schoolFee.email" placeholder="Enter your email address" tabindex="3" @change="removeError('email')">
					<span class="focus-input100"></span>
				</div>

				<div v-if="parentCheck==0" class="container-contact100-form-btn" id="login_btn_box">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<button class="contact100-form-btn" tabindex="4" id="login_btn" v-on:click.prevent="checkLogin()" >
							<span>
								Next
								<i class="fas fa-long-arrow-alt-right m-l-7"></i>
							</span>
						</button>
					</div>
				</div>

                <!-- step 2 -->
                <template v-if="parentCheck==1">
                    <div class="wrap-input100 validate-input highlight-disabled" data-validate = "Please select option">
                        <span id="label_ref" class="label-input100">Payment Type</span>
                        <input class="input100" type="text" id="product_name" name="PAYMENTFOR" :value="c_title" placeholder="Enter Invoice Number" tabindex="4" disabled>
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 validate-input" :data-validate="readError('reference_order')" v-bind:class="{ 'alert-validate':checkError('reference_order')}" >
                        <span id="reference_order" class="label-input100">Invoice Number</span>
                        <input class="input100" type="text" id="reference_order" v-model="schoolFee.reference_order" placeholder="Enter Invoice Number" tabindex="5" @change="removeError('reference_order')">
                        <span class="focus-input100"></span>
                    </div>                
                    <div class="wrap-input100 validate-input" data-validate = "Student Code is required" v-bind:class="{ 'alert-validate':checkError('student_code')}" >
                        <span id="student_code" class="label-input100">Student Code</span>
                        <input class="input100" type="text" id="student_code" v-model="schoolFee.student_code" placeholder="Enter Student Code" tabindex="6" @change="removeError('student_code')">
                        <span class="focus-input100"></span>
                    </div>                
                    <div class="wrap-input100 validate-input" data-validate = "Amount is required" v-bind:class="{ 'alert-validate':checkError('amount')}" >
                        <span id="label_amount" class="label-input100">School fee amount (THB)</span>
                        <input class="input100 money" type="number" id="amount" v-model="schoolFee.amount" placeholder="Enter Amount" value="" tabindex="7" @change="removeError('amount')">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 validate-input highlight-disabled" data-validate = "Valid amount is required">
                        <span id="label_amount" class="label-input100">Total amount (THB)</span>
                        <input class="input100 money" type="text" id="amount_show" :value="c_amount" tabindex="8" disabled>
                        <span class="focus-input100"></span>
                    </div>
                    
                    <div class="container-contact100-form-btn">
                        <div class="wrap-contact100-form-btn">
                            <div class="contact100-form-bgbtn"></div>
                            <button id="submit_btn" class="contact100-form-btn" tabindex="9" v-on:click.prevent="submitForm">
                                <span>
                                    Select Payment Method
                                    <i class="fas fa-long-arrow-alt-right m-l-7"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                    
                    <div style="padding-top: 5px; font-size: 3em; color: #A39163; text-align: center;">
                        <!-- <i class="fab fa-cc-visa"></i>&nbsp<i class="fab fa-cc-mastercard"></i> -->
                        <!-- <img src="images/visa.png">&nbsp;<img src="images/mastercard.png"> -->
                    </div>
                    
                    
                    <div id="foot_note" class="highlight-disabled form-note" >
						<span class="label-input100">
						&nbsp;&nbsp;&nbsp;&nbsp;Please enter the invoice no, student no. and amount and then 
                        click ‘Select Payment Method’ to take you to the page to pay school fees online with a processing fee.
						</span>
                    </div>
                </template>


				
				<!-- Button trigger modal 
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
				Launch demo modal
				</button>-->

				<!-- Modal -->
				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Contact Name</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body" >
							<img :src="imgPath.modal" width="100%">
						</div>
						<div class="modal-footer">
							<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
						</div>
						</div>
					</div>
				</div>
				
                <div id="dd" ></div>
			</form>

</template>

<script>
export default {
    data() {
        return {
            schoolFee: '',
            imgPath: '',
            url: '',
            startYear: 0,
            errors: [],
            dotPressed: false,
            cntDecimals: 0,
            parentCheck: 0,
        }
    },
    props: [ 'schoolFeeRaw', 'csrfToken', 'imgPathRaw', 'urlRaw' ],
    mounted() {
        this.schoolFee    = JSON.parse( this.schoolFeeRaw )
        this.imgPath      = JSON.parse( this.imgPathRaw   )
        this.url          = JSON.parse( this.urlRaw       )
    },
    methods: {
        submitForm(){
            //validate form and collect errors
            this.errors = this.validateFormTwo()

            //if there is no any error then submit the form
            if( this.errors.length==0 ){

                //store user schoolFee data and gen ref

                axios.post( "./school-fee/store", {
					'schoolFee'		: JSON.stringify(this.schoolFee),
                })
                .then( (response) => {
                    /** store schoolFee : source_type_id, source_type, payment_result, status */

                    $('#dd').html( response.data ) //for debug
                    let data = response.data
                    
                    $( '#submit_btn'     ).attr( 'disabled', true )

                    var order = { 
                        "endpoint_id": 2, 
                        "amount": data.amount,
                        "currency": 'THB',  
                        "description": this.c_title,
                        "reference_order": data.reference_order,
                        "customer_name": data.contact_name,
                        "customer_email": data.email,
                        "ref2": data.id,
                        "ref3": data.student_code
                    }
                    console.log( order )
                    $( '#PaymentForm'    ).attr( 'action', this.url['order'] )
                    $( '#PaymentForm'    ).attr( 'method', 'post'  )
                    $( 'input[name=order'  ).attr( 'value' , JSON.stringify(order) )
                    $( '#PaymentForm'    ).submit()
                })
            }
        },
        validateEmail(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        },
        validateForm(){
            var validate = true
            var errors   = []

            if( this.schoolFee.contact_name == '' ){
                $('#customer_name_label').attr("data-validate", "Contact name is required");
                errors.push( { 'id': 'contact_name', 'msg': "Contact Name required"     } )
            }

            if( (this.schoolFee.phone > 0)==false ){
                errors.push( { 'id': 'phone', 'msg': "Tel / Mobile No required"     } )
            }

            validate = this.validateEmail( this.schoolFee.email )
            if( validate==false ){
                $('#customer_email_label').attr("data-validate", "Valid email is required: ex@amail.com");
                errors.push( { 'id': 'email', 'msg': "Valid Email required"     } )
            }

            return errors
        },
        validateFormTwo(){
            var validate = true
            var errors   = []

            /**
             * validate inputs
             */
            if( this.schoolFee.reference_order == '' ){
                errors.push( { 'id': 'reference_order', 'msg': "Invoice Number required"     } )
                validate = false
            }
            if( this.schoolFee.student_code == '' ){
                errors.push( { 'id': 'student_code', 'msg': "Student Code required"     } )
            }
            if( (this.schoolFee.amount > 0)==false ){
                errors.push( { 'id': 'amount', 'msg': "Amount required"     } )
            }

            if( validate ){
                for( var i=0; i<errors.length; i++ )
                {
                    var temp = errors[ i ]
                    console.log(temp.id)
                    if( temp.id=='reference_order' ){
                        errors.splice( i, 1 )
                    }
                }
                if( this.schoolFee.reference_order.indexOf(' ') > -1 ){
                    errors.push( { 'id': 'reference_order', 'msg': "Must not contain a space"     } )
                    validate = false
                }
                else if( this.schoolFee.reference_order.indexOf(',') > -1 ){
                    errors.push( { 'id': 'reference_order', 'msg': "Must not contain a comma"     } )
                    validate = false
                }
            }

            return errors
        },
        readError( error_id ){
            if( this.errors.length>0 ){
                var error = this.errors.filter( error => error.id == error_id )
                return error[0].msg
            }
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
        checkLogin( )
		{            
			var customer_name  = this.schoolFee.contact_name
			var customer_phone = this.schoolFee.phone
			var customer_email = this.schoolFee.email
			
			//validate data before
			this.errors        = this.validateForm()

			if( this.errors.length==0 )
			{
				//ajax comes                
                
                axios.post( "./school-fee/check-parent", {
					'customer_name'		: customer_name,
					'customer_email'	: customer_email,
					'customer_phone'	: customer_phone,
                })
                .then( (parent_data) => {
                    /** update order : source_type_id, source_type, payment_result, status */

                    // $('#dd').html( parent_data.data ) //for debug
                    let data = parent_data.data

                    customer_name  = data.customer_name;
                    customer_phone = customer_phone; //keep the original
                    customer_email = data.customer_email;
                    
                    let confirmed  = data.found_email && data.found_contact;

                    if( confirmed )
                    {
                        $('#info-contact-name').hide();

                        //replace LoginForm with PaymentForm 
                        this.submitLoginFormToPaymentForm( customer_name, customer_phone, customer_email );
                    }
                    else {
                        if( !data.found_email )
                        {
                            $('#customer_email_label').attr("data-validate", "Could not find your email in the portal")
                            this.errors.push( { 'id': 'email', 'msg': "Could not find your email in the portal"     } )
                        }

                        if( !data.found_contact )
                        {
                            $('#customer_name_label').attr("data-validate", "Contact Name does not match")
                            this.errors.push( { 'id': 'contact_name', 'msg': "Contact Name does not match"     } )
                        }
                    }
                })
			}		
        },
        submitLoginFormToPaymentForm( customer_name, customer_phone, customer_email ){
            
			//remove spaces from customer_phone
			customer_phone = customer_phone.replace(/ /g,'');

			//XXX XXX XXXX
            // var format_phone_number = customer_phone.slice(0, 3) + " " + customer_phone.slice(3,6) + " " + customer_phone.slice(6) + " ";

			this.schoolFee.contact_name = customer_name;
			// this.schoolFee.phone        = format_phone_number;
			this.schoolFee.email        = customer_email;
			
			//disable input so users do not have to enter it again
			$( "#customer_name" ).prop( "disabled", true ); //Disable
			$( "#customer_name" ).parent().addClass( "highlight-disabled" ); 
			$( "#customer_phone" ).prop( "disabled", true ); //
			$( "#customer_phone" ).parent().addClass( "highlight-disabled" ); 
			$( "#customer_email" ).prop( "disabled", true ); //
			$( "#customer_email" ).parent().addClass( "highlight-disabled" );

            // this.genPaymentForm( );
            this.parentCheck = 1;
        },
        formatAmount(){
            $('#amount_show').attr( 'value', this.c_amount )
        },
		calServiceFee()
		{
			var amount_show  = document.forms["PaymentForm"]["amount_show"].value;//string type
			var service_fee  = 0;
			var total_fee    = 0;
			var amount; //keep amount_show as number type
			
			var pointIndex = amount_show.indexOf( '.' );
			if( pointIndex>=0 ) 
				this.dotPressed=true;
			else
				this.dotPressed=false;

			amount  = currencyStrToDouble( amount_show );

			service_fee  = amount * 0.013;
			total_fee    = parseFloat(amount) + service_fee;			

			if(!this.dotPressed)
				document.forms["PaymentForm"]["amount_show"].value = amount.format(this.cntDecimals);
			else{
				amount_show = cleanCurrencyStr( amount_show ).toString();
				document.forms["PaymentForm"]["amount_show"].value = amount_show;
			}

			document.forms["PaymentForm"]["service_fee"].value = service_fee.format(2);
			document.forms["PaymentForm"]["total_fee"].value   = total_fee ? total_fee.format(2) : parseFloat(0).toFixed(2);
		}
    },
    computed: {
        c_title(){
            var current_year = new Date().getFullYear() //yyyy
            return 'Tuition Fee ' + current_year
        },
        c_amount(){
            var currency= new Intl.NumberFormat('th-TH', { style: 'currency', currency: 'THB' }).format(this.schoolFee.amount)
            return currency
        }
    }
}
</script>

<style>
    .contact100-form-bgbtn{
        background: #031643;
    }
    .contact100-form-btn{
        color: white;
    }
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
    html {
        overflow-y:scroll;
    }
    .modal {
        overflow-y: auto;
    }

    .modal-open {
        overflow: auto;
    }

    .modal-open[style] {
        padding-right: 0px !important;
    }
</style>

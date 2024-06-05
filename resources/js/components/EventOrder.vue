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
					<span class="label-input100">Contact Name 
                        <!-- <span id="info-contact-name" style="color:#0056B3;"><a href="#" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-info-circle"></i></a></span> -->
                    </span>
					<input class="input100" type="text" id="customer_name" name="customer_name" v-model="eventOrder.contact_name" placeholder="Enter full contact name" tabindex="1" @focus="removeError('contact_name')">
					<span class="focus-input100"></span>
				</div>

				<div id="customer_phone_label" name="customer_phone_label" class="wrap-input100 validate-input" v-bind:class="{ 'alert-validate':checkError('phone')}" data-validate = "No '-/+' CHAR">
					<span class="label-input100">Tel / Mobile No.</span>
					<input class="input100" type="number" id="customer_phone" name="customer_phone" v-model="eventOrder.phone" placeholder="Enter your telephone number" tabindex="2" @focus="removeError('phone')">
					<span class="focus-input100"></span>
				</div>

				<div id="customer_email_label" name="customer_email_label" class="wrap-input100 validate-input" v-bind:class="{ 'alert-validate':checkError('email')}" data-validate = "Valid email is required: ex@amail.com">
					<span class="label-input100">Email </span>
					<input class="input100" type="text" id="customer_email" name="customer_email" v-model="eventOrder.email" placeholder="Enter your email address" tabindex="3" @focus="removeError('email')">
					<span class="focus-input100"></span>
				</div>

                <template v-if="tickets.length==1">
                    <div class="wrap-input100 validate-input highlight-disabled" data-validate = "Please select option">
                        <span id="label_ref" class="label-input100">Payment For</span>
                            <input class="input100" type="text" id="product_name" name="PAYMENTFOR" v-model="ticket.name" placeholder="Enter Invoice Number" tabindex="4" disabled>
                            <span class="focus-input100"></span>
                    </div>
                </template>

                <template v-else>   
                    <div class="wrap-input100 input100-select validate-input" data-validate = "Please select option" v-bind:class="{ 'alert-validate':checkError('ticket')}" >
                        <span class="label-input100">Payment For</span><br>
                        <select class="selection-2" id="product_name" name="PAYMENTFOR" v-model="eventOrder.event_ticket_id" style="width: 100%; height: 35px;" @change="updateTicket()" tabindex="4" @focus="removeError('ticket')"> 
                            <option selected value="0">-Select-</option>
                            <option v-for="t in tickets" :key="t.id" :value="t.id">{{t.name}}</option>
                        </select>
                        <span class="focus-input100"></span>
                    </div>
                </template>

                <template v-if="ticket!=''">
                    <div class="wrap-input100 validate-input" :data-validate="ticket.reference_text + ' is required'" v-bind:class="{ 'alert-validate':checkError('ref1')}" >
                        <span id="student_code" class="label-input100">{{ ticket.reference_text }}</span>
                        <input class="input100" type="text" id="ref1" v-model="eventOrder.ref1" :placeholder="'Enter ' + ticket.reference_text" tabindex="5" @focus="removeError('ref1')">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input" :data-validate="ticket.number_text + ' is required'" v-bind:class="{ 'alert-validate':checkError('ref2')}" >
                        <span id="reference_order" class="label-input100">{{ ticket.number_text }}</span>
                        <input class="input100 money" type="number" id="ref2" v-model="eventOrder.ref2" :placeholder="'Enter ' + ticket.number_text" tabindex="6" @focus="removeError('ref2')">
                        <span class="focus-input100"></span>
                    </div> 

                    <template v-if="ticket.price_type!='t'">
                        <div class="wrap-input100 validate-input" >
                            <span id="label_amount" class="label-input100">{{'Fee amount ('+ticket.currency+')'}}</span>
                            <input class="input100 money" type="number" id="amount" v-model="eventOrder.amount" placeholder="Enter Amount" value="" tabindex="7" disabled>
                            <span class="focus-input100"></span>
                        </div>
                    </template>

                    <div class="wrap-input100 validate-input highlight-disabled" >
                        <span id="label_amount" class="label-input100">{{'Price per unit ('+ticket.currency+')'}}</span>
                        <input class="input100 money" type="text" id="price_show" :value="c_price" tabindex="8" disabled>
                        <span class="focus-input100"></span>
                    </div>
                </template>

                <div class="wrap-input100 validate-input highlight-disabled" data-validate = "Valid amount is required">
                    <span id="label_amount" class="label-input100">{{'Total amount ('+ticket.currency+')'}}</span>
                    <input class="input100 money" type="text" id="amount_show" :value="c_amount" tabindex="9" disabled>
                    <span class="focus-input100"></span>
                </div>

                <div v-if="event.consent_1" class="wrap-input100 validate-input none-border" :data-validate="'required'" v-bind:class="{ 'alert-validate':checkError('consent_1')}" >
                    <input type="checkbox" class="my-check-box" v-model="eventOrder.consent_1" true-value="1" false-value="0" tabindex="10" @focus="removeError('consent_1')">
                    <span class="label-input100">{{event.consent_1}}</span>
                </div>

                <div v-if="event.consent_2" class="wrap-input100 validate-input none-border" :data-validate="'required'" v-bind:class="{ 'alert-validate':checkError('consent_2')}" >
                    <input type="checkbox" class="my-check-box" v-model="eventOrder.consent_2" true-value="1" false-value="0" tabindex="11" @focus="removeError('consent_2')">
                    <span class="label-input100">{{event.consent_2}}</span>
                </div>

                <div v-if="event.consent_3" class="wrap-input100 validate-input none-border" :data-validate="'required'" v-bind:class="{ 'alert-validate':checkError('consent_3')}" >
                    <input type="checkbox" class="my-check-box" v-model="eventOrder.consent_3" true-value="1" false-value="0" tabindex="12" @focus="removeError('consent_3')">
                    <span class="label-input100">{{event.consent_3}}</span>
                </div>

                <div v-if="event.consent_4" class="wrap-input100 validate-input none-border" :data-validate="'required'" v-bind:class="{ 'alert-validate':checkError('consent_4')}" >
                    <input type="checkbox" class="my-check-box" v-model="eventOrder.consent_4" true-value="1" false-value="0" tabindex="13" @focus="removeError('consent_4')">
                    <span class="label-input100">{{event.consent_4}}</span>
                </div>

                <div v-if="errors.length>0">
                    <span class="label-input100"><center style="color: #c80000; margin-top: -40px;">Please correct the red signs above</center></span>
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
            event: '',
            eventOrder: '',
            ticket: '',
            tickets: '',
            imgPath: '',
            url: '',
            errors: [],
        }
    },
    props: [ 'eventRaw', 'eventOrderRaw', 'ticketsRaw', 'csrfToken', 'imgPathRaw', 'urlRaw' ],
    mounted() {
        this.event      = JSON.parse( this.eventRaw     )
        this.eventOrder = JSON.parse( this.eventOrderRaw)
        this.tickets    = JSON.parse( this.ticketsRaw   )
        this.imgPath    = JSON.parse( this.imgPathRaw   )
        this.url        = JSON.parse( this.urlRaw       )

        if( this.tickets.length==1 ){
            this.ticket = this.tickets[0]
        }else {
            this.ticket = ''
        }
    },
    methods: {
        updateTicket(){
            let found = false
            for(let i=0; i<this.tickets.length; i++ ){
                if( this.tickets[i].id==this.eventOrder.event_ticket_id ){
                    this.ticket = this.tickets[i]
                    found = true
                    break
                }
            }
            if(!found)
                this.ticket = ''
        },
        submitForm(){
            //validate form and collect errors
            this.errors = this.validateForm()

            //if there is no any error then submit the form
            if( this.errors.length==0 ){

                //store user event data and gen ref

                axios.post( this.url.root + "/event/store", {
					'eventOrder'	: JSON.stringify(this.eventOrder)
                })
                .then( (response) => {
                    /** store event : source_type_id, source_type, payment_result, status */

                    $('#dd').html( response.data ) //for debug
                    ///*
                    let data = response.data
                    
                    $( '#submit_btn'     ).attr( 'disabled', true )

                    var order = { 
                        "endpoint_id": data.gate_endpoint_id, 
                        "amount": data.amount,
                        "currency": data.currency,  
                        "description": this.ticket.name,
                        "reference_order": data.reference_order,
                        "customer_name": data.contact_name,
                        "customer_email": data.email,
                        "ref2": data.ref1,
                        "ref3": data.ref2
                    }
                    console.log( order )
                    $( '#PaymentForm'    ).attr( 'action', this.url['order'] )
                    $( '#PaymentForm'    ).attr( 'method', 'post'  )
                    $( 'input[name=order'  ).attr( 'value' , JSON.stringify(order) )
                    $( '#PaymentForm'    ).submit()
                    //*/
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

            /**
             * validate inputs
             */

            if( this.eventOrder.contact_name == '' ){
                $('#customer_name_label').attr("data-validate", "Contact name is required");
                errors.push( { 'id': 'contact_name', 'msg': "Contact Name required"     } )
            }

            if( (this.eventOrder.phone > 0)==false ){
                errors.push( { 'id': 'phone', 'msg': "Tel / Mobile No required"     } )
            }

            validate = this.validateEmail( this.eventOrder.email )
            if( validate==false ){
                $('#customer_email_label').attr("data-validate", "Valid email is required: ex@amail.com");
                errors.push( { 'id': 'email', 'msg': "Valid Email required"     } )
            }

            if( this.ticket=='' ){
                errors.push( { 'id': 'ticket', 'msg': "Payment For required"     } )
            }

            if( (this.eventOrder.ref2 > 0)==false ){
                errors.push( { 'id': 'ref2', 'msg': this.ticket.number_text + " required"     } )
            }

            /**
             * consents
             */
            if( (this.eventOrder.consent_1=='0') && (this.event.consent_1_required==1) ){
                errors.push( { 'id': 'consent_1', 'msg': " required"     } )
            }
            if( (this.eventOrder.consent_2=='0') && (this.event.consent_2_required==1) ){
                errors.push( { 'id': 'consent_2', 'msg': " required"     } )
            }
            if( (this.eventOrder.consent_3=='0') && (this.event.consent_3_required==1) ){
                errors.push( { 'id': 'consent_3', 'msg': " required"     } )
            }
            if( (this.eventOrder.consent_4=='0') && (this.event.consent_4_required==1) ){
                errors.push( { 'id': 'consent_4', 'msg': " required"     } )
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
        submitLoginFormToPaymentForm( customer_name, customer_phone, customer_email ){
            
			//remove spaces from customer_phone
			customer_phone = customer_phone.replace(/ /g,'');

			//XXX XXX XXXX
            // var format_phone_number = customer_phone.slice(0, 3) + " " + customer_phone.slice(3,6) + " " + customer_phone.slice(6) + " ";

			this.eventOrder.contact_name = customer_name;
			// this.eventOrder.phone        = format_phone_number;
			this.eventOrder.email        = customer_email;
			
			//disable input so users do not have to enter it again
			$( "#customer_name" ).prop( "disabled", true ); //Disable
			$( "#customer_name" ).parent().addClass( "highlight-disabled" ); 
			$( "#customer_phone" ).prop( "disabled", true ); //
			$( "#customer_phone" ).parent().addClass( "highlight-disabled" ); 
			$( "#customer_email" ).prop( "disabled", true ); //
			$( "#customer_email" ).parent().addClass( "highlight-disabled" );

            // this.genPaymentForm( );
        },
        formatAmount(){
            $('#amount_show').attr( 'value', this.c_amount )
        },
    },
    computed: {
        c_price(){
            var currency = ''
            if( this.ticket=='' ){
                currency= new Intl.NumberFormat('th-TH', { style: 'currency', currency: 'THB' }).format(0)
            }else{
                currency= new Intl.NumberFormat('th-TH', { style: 'currency', currency: this.ticket.currency }).format(this.ticket.price)
            }
            return currency
        },
        c_amount(){
            if(this.ticket.price_type=='t'){ //ticket type
                this.eventOrder.amount = parseInt(this.eventOrder.ref2) * this.ticket.price
            }
            var currency = ''
            if( this.ticket=='' ){
                currency= new Intl.NumberFormat('th-TH', { style: 'currency', currency: 'THB' }).format(0)
            }else{
                currency= new Intl.NumberFormat('th-TH', { style: 'currency', currency: this.ticket.currency }).format(this.eventOrder.amount)
            }
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

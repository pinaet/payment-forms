<template>

			<form id="PaymentForm" class="contact100-form validate-form" method="post" onkeydown="return event.key != 'Enter';" >
                <input type="hidden" name="_token"  v-bind:value="csrfToken">
                <input type="hidden" name="order" value="">
				<span class="contact100-form-title">
					<img class="logo" :src="imgPath.logo"><br>
					<!-- Payment Gateway -->
				</span>
				<p class="contact100-form-title">Application Fee<br>Payment</p>
                
                <template v-if="parentCheck==0">
                    <div id="foot_note" class="highlight-disabled form-note" style="margin-bottom: 20px" >
						<span class="label-input100">
						&nbsp;&nbsp;&nbsp;&nbsp;Please enter the student name and then 
                        click ‘Select Payment Method’ to take you to the page to pay application fees online with a processing fee.
						</span>
                    </div>
                </template>

				<div id="student_name_label" name="student_name_label" class="wrap-input100 validate-input" 
                    v-bind:class="{ 'alert-validate':checkError('student_name'), 'highlight-disabled':parentCheck==1 }"
                    data-validate="Student name not found">
					<span class="label-input100">Student Names<span id="info-student-name" style="color:#0056B3;"></span></span>
					<input class="input100" type="text" id="student_name" name="student_name" v-model="applicationFee.student_name" placeholder="Enter student name" tabindex="1" @keyup="removeError('student_name')" :disabled="parentCheck==1">
                    <button v-if="parentCheck==1" type="button" class="btn btn-outline-danger clear-button"  v-on:click.prevent="clearStudentName()"  ><i class="fas fa-ban"></i></button>
					<span class="focus-input100"></span>
				</div>
                <!-- step 2 -->
                <template v-if="parentCheck==1">
                    <div class="wrap-input100 validate-input highlight-disabled" >
                        <span id="label_amount" class="label-input100">Parent Name</span>
                        <input class="input100 " type="text" id="parent_name" name="parent_name" v-model="applicationFee.parent_name" tabindex="2" disabled>
                        <span class="focus-input100"></span>
                    </div>
                </template>

                <div id="parent_email_label" class="wrap-input100 validate-input" 
                    v-bind:class="{ 'alert-validate':checkError('parent_email'), 'highlight-disabled':parentCheck==1 }"
                    data-validate="Parent email not found">
                    <span id="label_amount" class="label-input100">Parent Email</span>
                    <input class="input100 " type="text" id="parent_email" name="parent_email" v-model="applicationFee.parent_email" placeholder="Enter parent email" tabindex="3" @keyup="removeError('parent_email')" :disabled="parentCheck==1">
                    <button v-if="parentCheck==0" type="button" class="btn btn-outline-secondary af-button" v-on:click.prevent="checkStudentName()" ><i class="fas fa-search"></i></button>
                    <span class="focus-input100"></span>
                </div>

                <!-- step 2 -->
                <template v-if="parentCheck==1">
                    <div class="wrap-input100 validate-input highlight-disabled" >
                        <span id="label_amount" class="label-input100">Payment Type</span>
                        <input class="input100 " type="text" id="payment_type" name="payment_type" v-model="applicationFee.payment_type" tabindex="4" disabled>
                        <!-- <input class="input100" type="text" id="product_name" name="PAYMENTFOR" :value="c_title" placeholder="Enter Invoice Number" tabindex="4" disabled> -->
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input " >
                        <span id="applicant_id_label" name="applicant_id_label" class="label-input100"
                        v-bind:class="{ 'alert-validate':checkError('applicant_id')}">Invoice Number</span>
                        <input class="input100 " type="text" id="applicant_id" name="applicant_id" v-model="applicationFee.applicant_id" tabindex="5" @keyup="removeError('applicant_id')">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 validate-input highlight-disabled" >
                        <span id="label_amount" class="label-input100">Total amount (THB)</span>
                        <input class="input100 money" type="text" id="amount_show" :value="c_total_amount" tabindex="6" disabled>
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

                <div class="modal fade" id="modalPleaseWait" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                    <div class="modal-dialog" role="document" style="width: auto; height: auto;">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center;">
                                <span style="text-align: center"><img :src="imgPath.loading" ><br>Now loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
			</form>

</template>

<script>

export default {
    data() {
        return {
            applicationFee: '',
            imgPath: '',
            url: '',
            data: '',
            errors: [],
            parentCheck: 0,
            currentStudent: '',
        }
    },
    props: [ 'applicationFeeRaw', 'csrfToken', 'imgPathRaw', 'urlRaw', 'dataRaw' ],
    mounted() {
        $("#modalPleaseWait").appendTo("body");

        this.applicationFee = JSON.parse( this.applicationFeeRaw )
        this.imgPath        = JSON.parse( this.imgPathRaw   )
        this.url            = JSON.parse( this.urlRaw       )
        this.data           = JSON.parse( this.dataRaw      )

        if(this.applicationFee.student_name.length>0){
            this.checkStudentName()
        }
    },
    methods: {
        checkStudentName( )
		{
			//validate data before
			this.errors        = this.validateForm()

			if( this.errors.length==0 )
			{
                $('#modalPleaseWait').modal({backdrop: 'static', keyboard: false})  
                $('#modalPleaseWait').modal('toggle')
                
				//ajax comes
                
                axios.post(  this.url.base + "/application-fee/check-student", {
					'student_name'	: this.applicationFee.student_name,
					'parent_email'	: this.applicationFee.parent_email,
					'data'	        : this.data,
                })
                .then( ( parent_data ) => {
                    /** update order : source_type_id, source_type, payment_result, status */

                    $('#dd').html( parent_data.data ) //for debug
                    
                    // console.log( parent_data.data.student )

                    // found student & parent ?
                    this.parentCheck = false

                    var student      = parent_data.data.student
                    var parent       = parent_data.data.parent
                    if( ( typeof student !== 'undefined' && student != null) && ( typeof parent !== 'undefined' && parent != null) )
                    {                        
                        this.applicationFee.student_name = student.first_name + ' ' + student.last_name
                        this.applicationFee.parent_name  = parent.name
                        this.applicationFee.parent_email = parent.email
                        this.applicationFee.applicant_id = parent_data.data.invoice_number
                        
                        this.parentCheck                 = true
                    }

                    if( this.parentCheck==false )
                    {
                        $('#student_name_label').attr("data-validate", "Some information not matched")
                        this.errors.push( { 'id': 'student_name', 'msg': "Some information not matched"     } )
                        $('#parent_email_label').attr("data-validate", "Some information not matched")
                        this.errors.push( { 'id': 'parent_email', 'msg': "Some information not matched"     } )
                    }

                    $('#modalPleaseWait').modal('toggle')
                })
			}		
        },
        clearStudentName(){
            this.applicationFee.student_name = ''
            this.applicationFee.parent_name  = ''
            this.applicationFee.parent_email = ''
            this.applicationFee.applicant_id = ''
            
            this.parentCheck                 = false
            this.errors                      = []
        },
        submitForm(){

			//validate data before
            this.errors        = this.validateForm()
            console.log( this.errors )

			if( this.errors.length==0 )
			{
                // $('#modalPleaseWait').modal({backdrop: 'static', keyboard: false})  
                // $('#modalPleaseWait').modal('toggle')

                //store user applicationFee data and gen ref

                axios.post( this.url.base + "/application-fee/store", {
                    'applicationFee'		: JSON.stringify(this.applicationFee),
                })
                .then( (response) => {
                    /** store applicationFee : source_type_id, source_type, payment_result, status */

                    $('#dd').html( response.data ) //for debug
                    let data = response.data

                    var order = { 
                        "endpoint_id": data.endpoint_id, 
                        "amount": data.total_amount,
                        "currency": data.currency,  
                        "description": data.payment_type,
                        "reference_order": data.applicant_id,
                        "customer_name": data.parent_name,
                        "customer_email": data.parent_email,
                        "ref2": data.id,
                        "ref3": data.applicant_id
                    }
                    console.log( order )
                    if( typeof order.amount != 'undefined' )
                    {
                        $( '#submit_btn'     ).attr( 'disabled', true )
                        $( '#PaymentForm'    ).attr( 'action', this.url['order'] )
                        $( '#PaymentForm'    ).attr( 'method', 'post'  )
                        $( 'input[name=order').attr( 'value' , JSON.stringify(order) )
                        $( '#PaymentForm'    ).submit()

                        $('#modalPleaseWait').modal('toggle')
                    }
                })                
			}		
        },
        validateForm(){
            var validate = true
            var errors   = []

            if( this.applicationFee.student_name == '' ){
                $('#student_name_label').attr("data-validate", "Student name is required");
                errors.push( { 'id': 'student_name', 'msg': "Student name required"     } )
            }

            if( this.applicationFee.parent_email == '' ){
                $('#parent_email_label').attr("data-validate", "Parent email is required");
                errors.push( { 'id': 'parent_email', 'msg': "Parent email required"     } )
            }

            if( this.parentCheck==true && this.applicationFee.applicant_id == '' ){
                $('#applicant_id_label').attr("data-validate", "Invoice Number is required");
                errors.push( { 'id': 'applicant_id', 'msg': "Invoice Number required"     } )
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
        c_title(){
            var current_year = new Date().getFullYear() //yyyy
            return 'Tuition Fee ' + current_year
        },
        c_fee_amount(){
            var currency= new Intl.NumberFormat('th-TH', { style: 'currency', currency: this.applicationFee.currency }).format(this.applicationFee.fee_amount)
            return currency
        },
        c_total_amount(){
            var currency= new Intl.NumberFormat('th-TH', { style: 'currency', currency: this.applicationFee.currency }).format(this.applicationFee.total_amount)
            return currency
        },
    },
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

    .af-button {
        margin-top: -38px;
        margin-right: -48px;
        float: right;
    }

    .clear-button{
        margin-top: -43px;
        margin-right: 8px;
        float: right;
    }
</style>

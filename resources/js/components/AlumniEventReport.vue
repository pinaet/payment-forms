<template>
    <div>
        <table id="mytable" class="table table-striped table-bordered table-hover" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Edit Status</th>
                    <th>Status</th>
                    <th>First Name</th>
                    <th>Surname</th>
                    <th>School</th>
                    <th>Year of Graduation</th>
                    <th>Country Phone Code</th>
                    <th>Mobile Phone Number</th>
                    <th>Email</th>
                    <th>IOH CONNECT Membership</th>
                    <th>Info Confirmation</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                </tr>
            </thead>
            <!-- 
                
            $attributes['firstname']        = '';
            $attributes['lastname']         = '';
            $attributes['school_id']        = 0;
            $attributes['graduated_year']   = 0;
            $attributes['country_id']       = 0;
            $attributes['phone']            = '';
            $attributes['email']            = '';
            $attributes['ioh_connect']      = 0;
            $attributes['terms_agreed']     = 0;
            $attributes['event_status_id']  = 0;
            -->
            <tbody>
                <tr v-for="alumnus in alumni" :key="alumnus.id">
                    <td>{{alumnus.id}}</td>
                    <td>
                        <select v-model="alumnus.event_status_id"  @change="updateStatus( alumnus.id )">
                            <option value="0" >- Please select -</option>
                            <option v-for="eventStatus in eventStatuses" :key="eventStatus.id" :value="eventStatus.id" :selected="eventStatus.id==alumnus.event_status_id">{{ eventStatus.event_status }}</option>
                        </select>
                    </td>
                    <template >
                        <td>
                            {{ getEventStatusById( alumnus.event_status_id ) }}
                        </td>
                    </template>
                    <td>{{alumnus.firstname}}</td>
                    <td>{{alumnus.lastname}}</td>
                    <td>{{alumnus.school}}</td>
                    <td>{{alumnus.graduated_year}}</td>
                    <td>{{alumnus.phonecode}}</td>
                    <td>{{alumnus.phone}}</td>
                    <td>{{alumnus.email}}</td>
                    <td>{{alumnus.ioh_connect}}</td>
                    <td>{{alumnus.terms_agreed}}</td>
                    <td>{{alumnus.created_at}}</td>
                    <td>{{alumnus.updated_at}}</td>
                </tr>
            </tbody>
        </table>
        <div id="dd"></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            alumni: '',
            eventStatuses: '',
            paths: '',
            errors: '',
        }
    },
    props: [ 'alumniRaw', 'eventStatusesRaw', 'pathsRaw', 'csrfToken' ],
    mounted() {
        this.alumni         = JSON.parse( this.alumniRaw        )
        this.eventStatuses  = JSON.parse( this.eventStatusesRaw )
        this.paths          = JSON.parse( this.pathsRaw         )
    },
    methods: {
        updateStatus( alumnus_id ){
            let index = this.alumni.findIndex(x => x.id == alumnus_id) //find its index instead

            let alumnus = this.alumni[ index ]

            axios.post( this.paths['report_update'], {
                'alumnus'		: JSON.stringify(alumnus),
            })
            .then( (response) => {
                /** store schoolFee : source_type_id, source_type, payment_result, status */

                // $('#dd').html( response.data ) //for debug
                let data = response.data
                if( data == '200 OK' ){
                    alert( 'Updated Status for ' + alumnus.firstname + ' ' + alumnus.lastname + ' successfully!' )
                }
                else {
                    alert( 'updated status failed..' )
                }
            })
        },
        getEventStatusById( id ){
            // myArray.findIndex(x => x.id === '45') //find its index instead
            // myArray.filter(x => x.id === '45') //get an array of matching elements or an array of objects
            // myArray.filter(x => x.id === '45').map(x => x.foo) //get an array of foo properties
            let temp = ''
            if( id!='' && id!=0 ){
                temp = this.eventStatuses.find(x => x.id == id ).event_status
            }

            return temp
        }
    },
    computed: {

    }
}
</script>

<style>
</style>

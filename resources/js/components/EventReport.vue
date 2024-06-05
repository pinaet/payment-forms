<template>

    <div class="col-lg-12 contain-table-div" >
        <table id="mytable" class="table table-striped table-bordered table-hover" width="100%">
            <thead>
                <tr>
                    <th v-for="col in columns" :key="col.id">{{col}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in rows" :key="row.id">
                    <td v-for="col in columns" :key="col.id">{{row[col]}}</td>
                </tr>
            </tbody>
        </table>
        <p>&nbsp;</p>
        <div id="dd"></div>
    </div>
    
</template>

<script>
export default {
    data() {
        return {
            event       : '',
            eventReport : '',
            eventUser   : '',
            rows        : '',
            paths       : '',
            errors      : '',
        }
    },
    props: [ 
        'eventRaw',
        'eventReportRaw',
        'eventUserRaw',
        'reportRaw',        
        'pathsRaw', 
        'csrfToken' 
        ],
    mounted() {
        this.event      = JSON.parse( this.eventRaw        )
        this.eventReport= JSON.parse( this.eventReportRaw  )
        this.eventUser  = JSON.parse( this.eventUserRaw    )
        this.rows       = JSON.parse( this.reportRaw       )
        this.paths      = JSON.parse( this.pathsRaw        )
    },
    methods: {
    },
    computed: {
        "columns": function columns() {
            if( this.rows.length == 0 ){
                return [];
            }
            return Object.keys( this.rows[0] )
        }
    }
}
</script>

<style>
</style>

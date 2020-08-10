<template>
<v-container class="text-center">
    <div class="images">
     <img src="https://redhunter.id/wp-content/uploads/2020/01/redhunter-logo-1.png" width="300px">
    </div>
    <v-simple-table>
    <template v-slot:default>
      <thead>
         <tr>
            <th  class="text-center">Class Name</th>
            <th  class="text-center">Courses</th>
            <th  class="text-center">Trainer</th>
            <th  class="text-center">Start</th>
            <th  class="text-center">End</th>
            <th  class="text-center">Total Hadir</th>
        </tr>
      </thead>
      <tbody>
       <tr v-for="item in items" :key="item.data.id">
                <td>{{item.data.name}}</td>
                <td>{{item.data.courses.name}}</td>
                <td>
                     <v-list-item>
                        <v-list-item-avatar>
                            <v-img :src="item.data.trainer.foto_trainer ? item.data.trainer.foto_trainer : this.urlDefault + 'storage/defaultprofile.jpg'"></v-img>
                        </v-list-item-avatar>

                        <v-list-item-content>
                             {{item.data.trainer.name}}
                        </v-list-item-content>
                    </v-list-item>
                </td>
                <td>{{item.data.jam_masuk | mencoba}}</td>
                <td>{{item.data.jam_pulang | mencoba}}</td>
                <td>{{item.data.total_hadir}}</td>
            </tr>
      </tbody>
    </template>
    </v-simple-table>
</v-container>

</template>
<style lang="css" scoped>

/* .images{
    background-color: black !important;
    margin-bottom: 30px;
} */
 .v-data-table.theme--light{
     -webkit-box-shadow: 4px 4px 5px 0px rgba(0,0,0,0.75) !important;
-moz-box-shadow: 4px 4px 5px 0px rgba(0,0,0,0.75) !important;
box-shadow: 4px 4px 5px 0px rgba(0,0,0,0.75) !important;
 }
    thead{
        background-color: black !important;
    }
    th{
        color: white !important;
    }
</style>
<script>
import {mapGetters} from 'vuex'
import Pusher from 'pusher-js';
export default {
    data : ()=>({
        items:[]
    }),
    filters:{
        mencoba: function (value) {
            let jam = value.split(':')
            return `${jam[0]}:${jam[2]}`
        }
    },
    computed:{
        ...mapGetters({
            urlDefault : 'BeforeUrl/urlDefault'
        })
    },
    methods:{
         async go(){
            let url = window.location.pathname
            await this.axios.get(url)
            .then((result) => {
                this.items = result.data.data
            }).catch((err) => {
                console.log(err.response)
            });

            console.log(this.items)
        }
    },
    created(){

        var pusher = new Pusher('2808afa6e874e66aa7f3', {
        cluster: 'ap1',
        forceTLS: true
        });
        let fngsi =() => {
            this.go()
        }

        fngsi()
        var channel = pusher.subscribe('push');
        channel.bind("my-push", function(data) {
        // app.messages.push(JSON.stringify(data));
             fngsi()
        });
    }
}
</script>

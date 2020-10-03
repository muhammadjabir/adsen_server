<template>
    <v-app>
        <Progress v-if="loading"/>
        <v-container v-if="!loading">
            <v-card
                outlined
                class="mx-auto"
                >
                <v-card-title>
                    Daftar Kelas
                    
                </v-card-title>

                <v-card-text>
                     <v-simple-table>
                        <template v-slot:default>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Mulai Kelas - Akhir Kelas</th>
                                    <th>Trainer</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        <tbody>
                           <tr v-for="(item, index) in data" :key="index">
                                <td>{{index+1}}</td>
                                <td>{{item.data.name}}</td>
                                <td>
                                    <ul>
                                        <li v-for="kel in item.data.hari_masuk" :key="kel">{{kel}}</li>
                                    </ul>
                                </td>
                                <td>{{item.data.jam_masuk}} - {{item.data.jam_pulang}}</td>
                                <td>{{item.data.start_class}} - {{item.data.end_class}}</td>
                                <td>{{item.data.trainer.name}}</td>
                                <td>{{item.data.status}}</td>
                            </tr>
                        </tbody>
                        </template>
                    </v-simple-table>
                </v-card-text>
            </v-card>
        </v-container>
    </v-app>

</template>
<script>

import CrudMixin from '../../mixins/CrudMixin'
export default {
    name: 'video',
    mixins:[CrudMixin]
}
</script>

<style lang="css">
    .table {
      border-collapse: collapse;
      
  }
    table, th, td {
    border: 1px solid #efefef;
    }
  /* .table tr td, .table tr th {
      padding: 10px;
      text-align: left;
  }
    .table tr th {
        background-color:#f5f5f5;
        color: black;
    } */
</style>


<template>
    <v-app>
        <v-container>
            <BtnJudul text="Video Courses" />

            <v-card
            class="border-edit"
            tile
            >
                <!-- <v-card-text class="text-center"> -->
                <v-card-text>
                    <v-container>
                        <v-progress-linear
                        v-model="video_loading"
                        height="25"
                        color="success"
                        v-if="this.loading"
                        >
                        <strong>{{ Math.ceil(video_loading) }}%</strong>
                        </v-progress-linear>
                        <v-form
                        ref="form"
                        v-model="valid"
                        :lazy-validation="lazy"
                        v-if="!this.loading"
                        >
                        <label for="" align="left">{{editStatus == true ? 'Edit Video' : 'Upload New Video'}}</label>

                        <v-text-field
                        v-model="nama"
                        :rules="requiredRules"
                        label="Judul Video"
                        required
                        ></v-text-field>

                        <input type="file"  id="video_courses" ref="video_courses" accept="video/*" @change="eventChange">
                        <br>
                        <video controlslist="nodownload" width="50%" controls v-if="urlvideo" :src="urlvideo">
                            
                        </video>



                        <v-row>
                            <v-col
                            cols="12"
                            align="right"
                            >
                                <v-btn
                                color="red"
                                tile
                                style="color:white !important"
                                @click="editStatus = false"
                                v-if="editStatus == true"
                                >
                                Cancle
                                </v-btn>
                              <v-btn
                                :disabled="!valid"
                                color="success"
                                tile
                                @click="editStatus == true ? updateVideo() : save()"
                                :loading="loading"
                                >
                                {{editStatus == true ? 'Update' : 'Simpan'}}
                                </v-btn>
                            </v-col>
                        </v-row>

                    </v-form>
                    </v-container>

                </v-card-text>

                <v-card-actions class="">

                </v-card-actions>
            </v-card>

            <v-row>
                <v-col  cols="12"
                md="4"
                 v-for="item in data" :key="item.id" >
                <v-card
           
                >
                <div class="button-video">
                    <v-btn x-small dark @click="showDelete(item.id)" >
                        <v-icon>fas fa-window-close</v-icon>
                    </v-btn>
                    <v-btn x-small dark @click="editVideo(item.id,item.link,item.judul)">
                        <v-icon>mdi-circle-edit-outline</v-icon>
                    </v-btn>
                    
                </div>
                <video controlslist="nodownload" width="100%"  :src="item.link" @click="view(item.link,item.judul)">
                            
                </video>
                
                <v-card-title>{{item.judul}}</v-card-title>
                </v-card>
                </v-col>
                
            </v-row>
        </v-container>
    
    <v-dialog
      v-model="viewDialog"
      width="700px"
    >
      <v-card>
        <v-card-title class="headline">{{viewJudul}}</v-card-title>

        <v-card-text>
            <video controlslist="nodownload" width="100%" controls  :src="viewVideo"></video>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            color="black darken-1"
            text
            @click="viewDialog = false"
          >
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="dialogDelete"
      width="300px"
    >
      <v-card>
        <v-card-title class="headline">Apa anda yakin menghapus video !! </v-card-title>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            color="black darken-1"
            text
            @click="dialogDelete = false"
          >
            Cancel
          </v-btn>

          <v-btn
            color="black darken-1"
            text
            @click="deleteVideo"
          >
            Delete
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    </v-app>
</template>
<script>
// import {mapActions} from 'vuex'
import VideoMixin from '../../mixins/VideoMixins'
export default {
    data() {
        return {
            video_loading: 0,
            data: [],
            viewDialog:false,
            viewVideo:'',
            viewJudul:'',
            idDelete: '',
            dialogDelete: false,
            editStatus: false,
            idEdit: ''

        }
    },
    name: 'video.edit',

    mixins:[VideoMixin],
    methods:{
        async save(){
            this.loading = true
            let url = window.location.href
            url = new URL(url)
            let slug = url.searchParams.get("slug");
            let data = new FormData()
            data.append('nama',this.nama)
            data.append('video',this.video)
            data.append('slug',slug)
            await this.axios.post('/video',data,{
                headers: this.config.headers,
                onUploadProgress: progressEvent => {
                    if (progressEvent.lengthComputable) {
                        this.video_loading = (progressEvent.loaded/progressEvent.total) * 100
                    }               
                }
            })
            .then((ress) => {
                this.setSnakbar({
                    status:true,
                    pesan:ress.data.message,
                    color:'success'
                })
                this.nama = ''
                this.video = ''
                this.urlvideo = ''
                this.go()
            })
            .catch((err)=>{
               
                this.setSnakbar({
                status:true,
                color:'red',
                pesan:"Terjadi Kesalahan",
                })

                console.log(err.response)
            })
            this.loading = false

        },

        async go() {
            let url = window.location.href
            url = new URL(url)
            let slug = url.searchParams.get("slug");
            url = window.location.pathname
            this.axios(`${url}?slug=${slug}`,this.config)
            .then((ress) => {
                this.data = ress.data.videos
            })
            .catch((err) => {
                console.log(err.response)
            })
        },
        eventChange(event){
            const files = event.target.files
            this.video = files[0]
             const fileReader = new FileReader()
            fileReader.addEventListener('load',()=>{
                this.urlvideo=fileReader.result
            })
             fileReader.readAsDataURL(this.video)
            // this.urlvideo = URL.createObjectURL(this.video)
        },

        view(video,judul) {
            this.viewVideo = video
            this.viewJudul = judul
            this.viewDialog = true
        },
        showDelete(id){
            this.idDelete = id
            this.dialogDelete = true
        },
        async deleteVideo() {
            let data = new FormData()
            data.append('_method','DELETE')
            await this.axios.post(`video/${this.idDelete}`,data,this.config)
                    .then((ress) => {
                        this.setSnakbar({
                            status:true,
                            pesan:ress.data.message,
                            color:'success'
                        })
                        this.go()
                    })
                    .catch((err) => {
                        this.setSnakbar({
                            status:true,
                            pesan:'Terjadi Kesalahan',
                            color:'red'
                        })
                        console.log(err.response)
                    })
            this.dialogDelete = false
        },

        editVideo(id,url,judul) {
            this.editStatus = true
            this.idEdit = id
            this.urlvideo = url
            this.nama = judul
        },

        async updateVideo() {
            this.loading = true
            let url = window.location.href
            let data = new FormData()
            data.append('_method','PUT')
            data.append('nama',this.nama)
            data.append('video',this.video)
            await this.axios.post(`/video/${this.idEdit}`,data,{
                headers: this.config.headers,
                onUploadProgress: progressEvent => {
                    if (progressEvent.lengthComputable) {
                        this.video_loading = (progressEvent.loaded/progressEvent.total) * 100
                    }               
                }
            })
            .then((ress) => {
                this.setSnakbar({
                    status:true,
                    pesan:ress.data.message,
                    color:'success'
                })
                this.nama = ''
                this.video = ''
                this.urlvideo = ''
                this.go()
                this.editStatus = false
            })
            .catch((err)=>{
               
                this.setSnakbar({
                status:true,
                color:'red',
                pesan:"Terjadi Kesalahan",
                })

                console.log(err.response)
            })
            this.loading = false
        }
    },

    created(){
        this.go()
    }

}
</script>

<style lang="css" scoped>
    .v-card video:hover {
        cursor: pointer;
    }
    .v-card:hover div.button-video{
        display: block;
    }
    div.button-video button {
        border-radius: none;
    }
    div.button-video  {
        position: absolute;
        right: 0px;
        top: 0px;
        z-index: 1;
        display: none;
    }
</style>

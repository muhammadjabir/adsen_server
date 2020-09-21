export default  {
    path: '/video',
    component:()=>import('../views/index.vue'),
    meta:{auth:true},

    children: [
        {
            path: '',
            name: 'video.index',
            component:()=>import('../views/video/index.vue'),
        },
        {
            path:'create',
            name:'video.create',
            component:()=>import('../views/video/create.vue')
        },
       
    ]
}

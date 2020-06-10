export default  {
    path:'/schedule',
    component:() => import('../views/index.vue'),
    meta:{auth:true},
    children:[
        {
            path:'',
            name:'schedule.index',
            component:() => import('../views/schedule/index.vue')
        },
        {
            path:':id/absen',
            name:'schedule.absen',
            component:()=>import('../views/schedule/absen.vue')
        }
    ]
}

export default  {
    path:'/rekening',
    component:() => import('../views/index.vue'),
    meta:{auth:true},
    children:[
        {
            path:'',
            name:'rekening.index',
            component:() => import('../views/rekening/index.vue')
        },
        {
            path:'create',
            name:'rekening.create',
            component:()=> import('../views/rekening/create.vue')
        },
        {
            path:':id/edit',
            name:'rekening.edit',
            component:()=> import('../views/rekening/edit.vue')
        },
    ]
}

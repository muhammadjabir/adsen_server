export default  {
    path: '/loker',
    component:()=>import('../views/index.vue'),
    meta:{auth:true},

    children: [
        {
            path: '',
            name: 'loker.index',
            component:()=>import('../views/loker/index.vue'),
        },
        {
            path:'create',
            name:'loker.create',
            component:()=>import('../views/loker/create.vue')
        },
        {
            path:':id/edit',
            name:'loker.edit',
            component:()=>import('../views/loker/edit.vue')
        },
    ]
}

export default  {
    path: '/class-management',
    component:()=>import('../views/index.vue'),
    meta:{auth:true},

    children: [
        {
            path: '',
            name: '/class-management.index',
            component:()=>import('../views/class-management/index.vue'),
        },
        {
            path:'create',
            name:'/class-management.create',
            component:()=>import('../views/class-management/create.vue')
        },
        {
            path:'trash',
            name:'class.trash',
            component:()=>import('../views/trash/class.vue')
        },
        {
            path:':id/edit',
            name:'/class-management.edit',
            component:()=>import('../views/class-management/edit.vue')
        },
    ]
}

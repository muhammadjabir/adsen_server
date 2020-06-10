export default  {
    path: '/courses',
    component:()=>import('../views/index.vue'),
    meta:{auth:true},

    children: [
        {
            path: '',
            name: 'courses.index',
            component:()=>import('../views/courses-management/index.vue'),
        },
        {
            path:'create',
            name:'courses.create',
            component:()=>import('../views/courses-management/create.vue')
        },
        {
            path:':id/edit',
            name:'courses.edit',
            component:()=>import('../views/courses-management/edit.vue')
        },
    ]
}

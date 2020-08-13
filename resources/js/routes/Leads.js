export default  {
    path: '/leads',
    component:()=>import('../views/index.vue'),
    meta:{auth:true},

    children: [
        {
            path: '',
            name: 'leads.index',
            component:()=>import('../views/leads/index.vue'),
        },
        {
            path:'create',
            name:'leads.create',
            component:()=>import('../views/leads/create.vue')
        },
        {
            path:':id/edit',
            name:'leads.edit',
            component:()=>import('../views/leads/edit.vue')
        },
    ]
}

export default  {
    path: '/trainers',
    component:()=>import('../views/index.vue'),
    meta:{auth:true},

    children: [
        {
            path: '',
            name: 'trainer.index',
            component:()=>import('../views/trainer/index.vue'),
        },
        {
            path:'create',
            name:'trainer.create',
            component:()=>import('../views/trainer/create.vue')
        },
        {
            path:':id/edit',
            name:'trainer.edit',
            component:()=>import('../views/trainer/edit.vue')
        },
    ]
}

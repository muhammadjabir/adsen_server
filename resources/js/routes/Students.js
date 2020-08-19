export default  {
    path:'/students',
    component:() => import('../views/index.vue'),
    meta:{auth:true},
    children:[
        {
            path:'',
            name:'students.index',
            component:() => import('../views/students/index.vue')
        },
        {
            path:'create',
            name:'students.create',
            component:()=> import('../views/students/create.vue')
        },
        {
            path:'trash',
            name:'student.trash',
            component:()=>import('../views/trash/student.vue')
        },
        {
            path:':id/edit',
            name:'students.edit',
            component:()=>import('../views/students/edit.vue')
        }
    ]
}

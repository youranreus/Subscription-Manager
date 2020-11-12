//components
let index_component = Vue.component('index_component', {
    template: `
        <div id="index">
            <img src="https://www.tupians.top/imgs/2020/10/4458047d1ad55d41.gif" alt="">
            <h2 class="t-text">简洁、高效、便捷</h2>
            <router-link to="/c"><button class="btn btn-primary btn-round">开始使用</button></router-link>
        </div>
    `
})
let machine_component = Vue.component('machine_component', {
    template: `
        <div id="main-panel" class="container">
        <div id="machine-list" class="clear">
            <h2>全部小鸡 </h2>
            <h3 v-if="isEmpty">还没有小鸡噢</h3>
            <div id="MachineList" class="clear" v-else>
                <div v-for="item in machines" class="machine-item">
                    <router-link :to="'/machine/'+ item.rowid">
                    <div class="machine-item-container">
                        <div class="header">
                            <h3>{{item.name}} <span class="right">{{item.location}}</span></h3>
                        </div>
                        <div class="content">
                            <span>￥{{item.fee}}/月</span>
                            <span class="right">{{item.HOST}}</span>
                        </div>
                    </div>
                    </router-link>
                    
                </div>
            </div> 
            <button class="btn btn-primary btn-link right" style='font-weight: 600;'><router-link to="/p">🔙返回</router-link></button>  
        </div>            
        </div>
    `,
    data: function () {
        return {
            'machines': [],
            'isEmpty': true
        }
    },
    methods: {},
    mounted() {
        axios.get('/X/getMachineList?type=all')
            .then((response) => {
                if (response.data.length !== 0) {
                    this.machines = response.data;
                    this.isEmpty = false;
                }
            })
    }

})
let u_component = Vue.component('u_component', {
    template: `
        <div id="login" class="container">
            <h2>登录~</h2>
            <div class="form-input-material">
                <input
                    class="form-control-material"
                    name="key"
                    id="key"
                    placeholder=" "
                    autocomplete="off"
                    v-model="pwd"
                    @keyup.enter="login"
                />
                <label for="key" >密钥</label>
            </div>
            <br/><br/>
            <div class="alert alert-info" v-if="msgStatus">
                {{msg}}
            </div>
        </div>
    `,
    data: function () {
        return {
            'logged': 'false',
            'pwd': '',
            'msg': '我要说啥来着？',
            'msgStatus': false
        }
    }
    ,
    methods: {
        login: function () {
            axios.get('/X/login?key=' + this.pwd)
                .then((response) => {
                    if (response.data.msg === 'true') {
                        Cookies.set('UserStatus', 'true', {expires: 7});
                        this.msg = '密钥正确';
                        this.msgStatus = true;
                        this.$router.push({path: '/p'})
                    } else {
                        this.msg = '密钥错误';
                        this.msgStatus = true;
                    }
                })
        },
        IfLogged: function () {
            this.logged = Cookies.get('UserStatus')
        }
    },
    mounted() {
        this.IfLogged()
        if (this.logged === 'true') {
            this.$router.push({path: '/p'})
        }
    }
})
let p_component = Vue.component('p_component', {
    template: `
        <div id="main-panel" class="container">
        
            <div id="machine-list" class="clear">
                <h2>⭐小鸡 </h2>
                <h3 v-if="isEmpty">还没有小鸡噢</h3>
                <div id="MachineList" class="clear" v-else>
                    <div v-for="item in machines" class="machine-item">
                        <router-link :to="'/p/'+ item.rowid">
                        <div class="machine-item-container">
                            <div class="header">
                                <h3>{{item.name}} <span class="right">{{item.location}}</span></h3>
                            </div>
                            <div class="content">
                                <span>￥{{item.fee}}/月</span>
                                <span class="right">{{item.HOST}}</span>
                            </div>
                        </div>
                        </router-link>
                    </div>
                </div>
                <router-view></router-view>   
                <button class="btn btn-primary btn-link right" style='font-weight: 600;'><router-link to="/machines">😀更多小鸡</router-link></button>
            </div>   
            
            <div id="info-panel">
                <h2 style="margin-bottom: 20px;">📜基本信息</h2>
                <div id="data-display">
                    <h3>💸开销</h3>
                    <div class="data-item">
                        <h4>{{info.fee}}</h4>
                        <span> 每月开销 </span>    
                    </div>
                    <div class="data-item">
                        <h4>{{info.feeLeast}}</h4>
                        <span> 基本开销 </span>    
                    </div>
                    <div class="data-item">
                        <h4>{{info.fee - info.feeLeast}}</h4>
                        <span> 可有可无の开销 </span>    
                    </div>
                    <h3>☁️机器</h3>
                    <div class="data-item">
                        <h4>{{info.machineNum}}</h4>
                        <span> 拥有小鸡数 </span>    
                    </div>
                    <div class="data-item endanger">
                        <h4>{{info.endangerMachine}}</h4>
                        <span> 即将过期小鸡 </span>    
                    </div>
                    <div class="data-item">
                        <h4>{{info.autoMachine}}</h4>
                        <span> 自动续费小鸡 </span>    
                    </div>
                    <div class="data-item">
                        <h4>{{info.manuelMachine}}</h4>
                        <span> 手动续费小鸡 </span>    
                    </div>
                </div>
            </div>
            
            <h2 class="t-text">简洁，快速，高效</h2>
                       
        </div>
    `,
    data: function () {
        return {
            'machines': [],
            'isEmpty': true,
            'info':[]
        }
    },
    methods: {},
    mounted() {
        axios.get('/X/getMachineList')
            .then((response) => {
                if (response.data.length !== 0) {
                    this.machines = response.data;
                    this.isEmpty = false;
                }
            })
        axios.get('/X/getInfo')
            .then((response)=>{
                if (response.data.length !== 0) {
                    this.info = response.data;
                }
            })
    }

})
let machine_detail_component = Vue.component('machine_detail_component', {
    template: `
        <div id="machine-detail" class="container">
            <h3>详细信息</h3>
            <div id="machine-detail-content">
                <p>{{machineDetail.rowid}}</p>
                <p>{{machineDetail.name}}</p>
                <p>{{machineDetail.liked}}</p>
                <p>{{machineDetail.deadline}}</p>
                <p>{{machineDetail.cycle}}</p>
                <p>{{machineDetail.fee}}</p>
                <p>{{machineDetail.auto}}</p>
                <p>{{machineDetail.panel}}</p>
                <p>{{machineDetail.ip}}</p>
                <p>{{machineDetail.info}}</p>
                <p>{{machineDetail.location}}</p>
                <p>{{machineDetail.Host}}</p>          
            </div>
        </div>
    `,
    data:function (){
        return {
            machineDetail : []
        }
    },
    methods:{
        getDetail: function(){
            axios.get('/X/getMachineDetail?id=' + this.$route.params.id)
                .then((response)=>{
                    this.machineDetail = response.data[0]
                })
            this.$nextTick()
        }
    },
    mounted(){
        this.getDetail()
    }
})


let routes = [
    {
        path: '/',
        component: index_component
    },
    {
        path: '/c',
        component: u_component
    },
    {
        path: '/p',
        component: p_component,
        children:[
            {
                path:':id',
                component:machine_detail_component
            }
        ]
    },
    {
        path: '/machines',
        component: machine_component
    }
    // {
    //     path: '/machine/:id',
    //     component: machine_detail_component
    // }
];

let router = new VueRouter({
    routes: routes,
});
new Vue({
    el: "#main",
    router: router,
    data: {
        logged: false
    }
})




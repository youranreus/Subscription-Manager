//components
let index_component = Vue.component('index_component', {
    template: `
        <div id="index">
            <img src="https://www.tupians.top/imgs/2020/10/4458047d1ad55d41.gif" alt="">
            <h2 class="t-text">简洁、高效、便捷</h2>
            <router-link to="/u"><button class="btn btn-primary btn-round">开始使用</button></router-link>
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
            <button class="btn btn-primary btn-link right" style='font-weight: 600;'><router-link to="/add">➕ 添加</router-link></button>
              
        </div>            
        </div>
    `,
    data: function () {
        return {
            'machines': [],
            'isEmpty': true,
            'logged':false
        }
    },
    methods: {},
    mounted() {
        this.logged = Cookies.get('UserStatus')
        if (this.logged !== 'true') {
            this.$router.push({path: '/u'})
        }
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
                    <div class="data-item endanger">
                        <h4>{{info.deadMachine}}</h4>
                        <span> 过期小鸡 </span>    
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
            'info':[],
            'logged':false
        }
    },
    methods: {},
    mounted() {
        this.logged = Cookies.get('UserStatus')
        if (this.logged !== 'true') {
            this.$router.push({path: '/u'})
        }
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
        <div class="container">
            <div id="machine-detail">
                <h2>🖨️详细信息-{{machineDetail.name}} <span @click="goBack">🔙 返回</span><span @click="goEdit">✍ 编辑</span>  </h2>
                <div id="machine-detail-content">
                    <div class="data-item">
                        <h4>{{machineDetail.deadline}}</h4>
                        <span> 过期日期 </span>    
                    </div>
                    <div class="data-item">
                        <h4>{{machineDetail.cycle}} 天</h4>
                        <span> 付费周期 </span>    
                    </div>
                    <div class="data-item">
                        <h4>{{machineDetail.fee}} 元</h4>
                        <span> 月消费 </span>    
                    </div>
                    <div class="data-item">
                        <h4>{{machineDetail.auto==1 ? '是' : '否'}}</h4>
                        <span> 是否自动续费 </span>    
                    </div>
                    <div class="data-item">
                        <h4>{{machineDetail.HOST}}</h4>
                        <span> 主机商 </span>    
                    </div>
                    <div class="data-item">
                        <h4>{{machineDetail.location}}</h4>
                        <span> 位置 </span>    
                    </div>
                    
                    <div id="machine-otherDetail" class="clear">
                        <div class="left" style="width:50%">
                            <h3>相关地址</h3>
                            <a :href="machineDetail.panel"><button class="btn btn-info">面板</button></a>
                            <a :href="machineDetail.ip"><button class="btn btn-info">IP</button></a>
                            <h3>配置项</h3>
                            <p>收藏：{{machineDetail.liked==1 ? '是' : '否'}}</p>
                        </div>
                        <div class="right" style="width:45%;max-height: 300px;overflow-y: scroll;padding:10px;">
                            <h3>备注</h3>
                            <div id="machine-otherDetail-content" class="yue">
                            </div>       
                        </div>
                        </div>
                </div>
            </div>     
            
        </div>
    `,
    data:function (){
        return {
            machineDetail : [],
            gotDetail: false,
            logged:false
        }
    },
    methods:{
        getDetail: function(){
            axios.get('/X/getMachineDetail?id=' + this.$route.params.id)
                .then((response)=>{
                    this.machineDetail = response.data[0]
                    document.getElementById('machine-otherDetail-content').innerHTML = marked(this.machineDetail["info"]);
                })
            this.gotDetail = true
        },
        goBack: function(){
            this.$router.go(-1)
        },
        goEdit: function(){
            this.$router.push({path: '/machine/'+this.$route.params.id+'/edit'})
        }
    },
    mounted(){
        this.logged = Cookies.get('UserStatus')
        if (this.logged !== 'true') {
            this.$router.push({path: '/u'})
        }
        this.getDetail();
    }
})
let machine_edit_component = Vue.component('Machine_edit_component',{
    template:`
        <div class="container">
            <div id="machine-edit">
                <h2>✍ 正在编辑-{{machineDetail.name}} <span @click="goBack">🔙 返回</span><span @click="goDelete">🗑️ 删除</span></h2>
                <br/>
                <h3>基本信息</h3>
                <br/>
                <div class="form-input-material">
                    <input
                        class="form-control-material"
                        type="text"
                        name="name"
                        id="name"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.name"
                    />
                    <label for="name">小鸡名</label>
                </div>    
                <br/><br/>
                <div class="form-input-material">    
                    <input
                        class="form-control-material"
                        type="text"
                        name="fee"
                        id="fee"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.fee"
                    />
                    <label for="fee">每月费用</label>
                </div>  
                <br/><br/>  
                <div class="form-input-material">      
                    <input
                        class="form-control-material"
                        type="text"
                        name="host"
                        id="host"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.HOST"
                    />
                    <label for="host">主机商</label>
                </div>   
                <br/><br/> 
                <div class="form-input-material">      
                    <input
                        class="form-control-material"
                        type="text"
                        name="location"
                        id="location"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.location"
                    />
                    <label for="location">位置</label>
                </div>    
                <br/><br/>
                <div class="form-input-material">       
                    <input
                        class="form-control-material"
                        type="text"
                        name="ip"
                        id="ip"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.ip"
                    />
                    <label for="ip">IP</label>
                </div>    
                <br/><br/>
                <div class="form-input-material">       
                    <input
                        class="form-control-material"
                        type="text"
                        name="panel"
                        id="panel"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.panel"
                    />
                    <label for="panel">面板地址</label>
                </div>    
                <br/>
                <br/>
                <div class="form-input-material">       
                    <input
                        class="form-control-material"
                        type="text"
                        name="deadline"
                        id="deadline"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.deadline"
                    />
                    <label for="deadline">过期日期(yyyy-mm-dd)</label>
                </div> 
                <br/>
                <br/>
                <div class="form-input-material">       
                    <input
                        class="form-control-material"
                        type="text"
                        name="cycle"
                        id="cycle"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.cycle"
                    />
                    <label for="cycle">付款周期(天)</label>
                </div>
                <br/>
                <h3>自动续费开关</h3>
                    <div class="form-check">
                        <input type="radio" class="form-check-input bounce" id="auto-true" value="1" v-model="machineDetail.auto"/>
                        <label class="form-check-label" for="auto">自动续费</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input bounce" id="auto-false" value="0" v-model="machineDetail.auto"/>
                        <label class="form-check-label" for="auto">算了</label>
                    </div>
                <h3>加入收藏</h3>
                    <div class="form-check">
                        <input type="radio"  class="form-check-input bounce" value="1" v-model="machineDetail.liked"/>
                        <label class="form-check-label" for="liked">这必须收藏</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input bounce" value="0" v-model="machineDetail.liked"/>
                        <label class="form-check-label" for="liked">算了</label>
                    </div>
                    <br/>
                    <h3>备注</h3>
                    <textarea name="info" id="" cols="30" rows="10" v-model="machineDetail.info"></textarea>
                    <br><br>
                <button class="btn btn-primary" @click="update">保存</button>
                </div>
            </div>
        </div>
    `,
    data:function (){
        return {
            machineDetail : [],
            logged: false
        }
    },
    methods:{
        getDetail: function(){
            axios.get('/X/getMachineDetail?id=' + this.$route.params.id)
                .then((response)=>{
                    this.machineDetail = response.data[0]
               })
        },
        goBack: function(){
            this.$router.go(-1)
        },
        goDelete: function(){
            this.$router.push({path:'/machine/'+this.$route.params.id+'/delete'})
        },
        update: function(){
            if(this.machineDetail['name'] !== '' && this.machineDetail['liked'] !== '' && this.machineDetail['deadline'] !== '' && this.machineDetail['location'] !== '' && this.machineDetail['fee'] !== '' && this.machineDetail['cycle'] !== '' && this.machineDetail['auto'] !== '' && this.machineDetail['panel'] !== ''  && this.machineDetail['info'] !== '' && this.machineDetail['HOST'] !== '' && this.machineDetail['ip'] !== ''){
                axios.get('/X/updateMachineDetail?id='+this.$route.params.id + '&name='+this.machineDetail['name']+'&liked='+this.machineDetail['liked']+'&deadline='+this.machineDetail['deadline']+'&location='+this.machineDetail['location']+'&fee='+this.machineDetail['fee']+'&cycle='+this.machineDetail['cycle']+'&auto='+this.machineDetail['auto']+'&panel='+this.machineDetail['panel']+'&info='+this.machineDetail['info']+'&HOST='+this.machineDetail['HOST']+'&ip='+this.machineDetail['ip'])
                    .then((response)=>{
                        if(response.data === 1){
                            alert("编辑成功")
                            this.$router.go(-1)
                        }
                    })
            }else{
                alert('有什么东西没填完？');
            }
        }
    },
    mounted(){
        this.logged = Cookies.get('UserStatus')
        if (this.logged !== 'true') {
            this.$router.push({path: '/u'})
        }
        this.getDetail();
    }
})
let machine_add_component = Vue.component('Machine_add_component',{
    template:`
        <div class="container">
            <div id="machine-add">
                <h2>添加小鸡<span @click="goBack">🔙 返回</span></h2>
                <br/>
                <h3>基本信息</h3>
                <br/>
                <div class="form-input-material">
                    <input
                        class="form-control-material"
                        type="text"
                        name="name"
                        id="name"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.name"
                    />
                    <label for="name">小鸡名</label>
                </div>    
                <br/><br/>
                <div class="form-input-material">    
                    <input
                        class="form-control-material"
                        type="text"
                        name="fee"
                        id="fee"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.fee"
                    />
                    <label for="fee">每月费用</label>
                </div>  
                <br/><br/>  
                <div class="form-input-material">      
                    <input
                        class="form-control-material"
                        type="text"
                        name="host"
                        id="host"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.HOST"
                    />
                    <label for="host">主机商</label>
                </div>   
                <br/><br/> 
                <div class="form-input-material">      
                    <input
                        class="form-control-material"
                        type="text"
                        name="location"
                        id="location"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.location"
                    />
                    <label for="location">位置</label>
                </div>    
                <br/><br/>
                <div class="form-input-material">       
                    <input
                        class="form-control-material"
                        type="text"
                        name="ip"
                        id="ip"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.ip"
                    />
                    <label for="ip">IP</label>
                </div>    
                <br/><br/>
                <div class="form-input-material">       
                    <input
                        class="form-control-material"
                        type="text"
                        name="panel"
                        id="panel"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.panel"
                    />
                    <label for="panel">面板地址</label>
                </div>  
                <br/><br/>
                <div class="form-input-material">       
                    <input
                        class="form-control-material"
                        type="text"
                        name="deadline"
                        id="deadline"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.deadline"
                    />
                    <label for="deadline">过期日期(yyyy-mm-dd)</label>
                </div>    
                <br/>
                <br/>
                <div class="form-input-material">       
                    <input
                        class="form-control-material"
                        type="text"
                        name="cycle"
                        id="cycle"
                        placeholder=" "
                        autocomplete="off"
                        v-model="machineDetail.cycle"
                    />
                    <label for="cycle">付款周期(天)</label>
                </div>
                <br/>
                <h3>自动续费开关</h3>
                    <div class="form-check">
                        <input type="radio" class="form-check-input bounce" id="auto-true" value="1" v-model="machineDetail.auto"/>
                        <label class="form-check-label" for="auto">自动续费</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input bounce" id="auto-false" value="0" v-model="machineDetail.auto"/>
                        <label class="form-check-label" for="auto">算了</label>
                    </div>
                <h3>加入收藏</h3>
                    <div class="form-check">
                        <input type="radio"  class="form-check-input bounce" value="1" v-model="machineDetail.liked"/>
                        <label class="form-check-label" for="liked">这必须收藏</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input bounce" value="0" v-model="machineDetail.liked"/>
                        <label class="form-check-label" for="liked">算了</label>
                    </div>
                    <br/>
                    <h3>备注</h3>
                    <textarea name="info" id="" cols="30" rows="10" v-model="machineDetail.info"></textarea>
                    <br><br>
                <button class="btn btn-primary" @click="add">添加</button>
                </div>
            </div>
        </div>
    `,
    data:function (){
        return {
            machineDetail : [],
            logged: false
        }
    },
    methods:{
        goBack: function(){
            this.$router.go(-1)
        },
        add: function(){
            if(this.machineDetail['name'] !== '' && this.machineDetail['liked'] !== '' && this.machineDetail['deadline'] !== '' && this.machineDetail['location'] !== '' && this.machineDetail['fee'] !== '' && this.machineDetail['cycle'] !== '' && this.machineDetail['auto'] !== '' && this.machineDetail['panel'] !== ''  && this.machineDetail['info'] !== '' && this.machineDetail['HOST'] !== '' && this.machineDetail['ip'] !== ''){
                axios.get('/X/AddMachine?id='+this.$route.params.id + '&name='+this.machineDetail['name']+'&liked='+this.machineDetail['liked']+'&deadline='+this.machineDetail['deadline']+'&location='+this.machineDetail['location']+'&fee='+this.machineDetail['fee']+'&cycle='+this.machineDetail['cycle']+'&auto='+this.machineDetail['auto']+'&panel='+this.machineDetail['panel']+'&info='+this.machineDetail['info']+'&HOST='+this.machineDetail['HOST']+'&ip='+this.machineDetail['ip'])
                    .then((response)=>{
                        if(response.data === 1){
                            alert("添加成功")
                            this.$router.go(-1)
                        }
                    })
            }else{
                alert('有什么东西没填完？');
            }
        }
    },
    mounted(){
        this.logged = Cookies.get('UserStatus')
        if (this.logged !== 'true') {
            this.$router.push({path: '/u'})
        }
    }
})
let machine_delete_component = Vue.component('machine_delete_component',{
    template:`
        <div class="container">
            <div id="machine-delete">
                <h2>🗑️ 正在删除 - {{machineDetail.name}} <span @click="goBack">🔙 饶它一命</span></h2>
                <br/>
                <br/>
                <p>真的要删除它吗？</p>
                <br/>
                <div class="form-input-material">
                    <input
                        class="form-control-material"
                        type="text"
                        name="input"
                        id="input"
                        placeholder=" "
                        autocomplete="off"
                        v-model="input"
                        @keyup.enter="ensureDelete"
                    />
                    <label for="input">请输入 "yes" 后敲击回车以继续</label>
                </div>    
                <br/><br/>
            </div>  
        </div>
    `,
    data:function (){
        return {
            machineDetail : [],
            gotDetail: false,
            input:'',
            logged: false
        }
    },
    methods:{
        getDetail: function(){
            axios.get('/X/getMachineDetail?id=' + this.$route.params.id)
                .then((response)=>{
                    this.machineDetail = response.data[0]
               })
            this.gotDetail = true
        },
        goBack: function(){
            this.$router.go(-1)
        },
        ensureDelete: function(){
            if(this.input === 'yes'){
                axios.get('/X/DeleteMachine?id='+this.$route.params.id)
                    .then((response)=>{
                        if(response.data === 1){
                            alert('删除成功~')
                            this.$router.push({path: '/machines'})
                        }else{
                            alert('删除失败~')
                        }
                    })
            }else{
                alert("你的意志还是不够坚定");
            }
        }
    },
    mounted(){
        this.logged = Cookies.get('UserStatus')
        if (this.logged !== 'true') {
            this.$router.push({path: '/u'})
        }
        this.getDetail();
    }
})

let routes = [
    {
        path: '/',
        component: index_component
    },
    {
        path: '/u',
        component: u_component
    },
    {
        path: '/p',
        component: p_component
    },
    {
        path: '/machines',
        component: machine_component
    },
    {
        path: '/machine/:id',
        component: machine_detail_component
    },
    {
        path: '/machine/:id/edit',
        component: machine_edit_component
    },
    {
        path: '/add',
        component: machine_add_component
    },
    {
        path: '/machine/:id/delete',
        component: machine_delete_component
    },
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




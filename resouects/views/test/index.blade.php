<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<link rel="stylesheet" href="{{ asset('large/js/index.css') }}">
<link rel="stylesheet" href="{{ asset('large/layer/skin/default/layer.css') }}">
<link rel="stylesheet" href="{{ asset('large/layer/skin/default/layer.css') }}">


<style>
    .el-row {
        margin-bottom: 20px;
    &:last-child {
         margin-bottom: 0;
     }
    }
    .el-col {
        border-radius: 4px;
    }
    .bg-purple-dark {
        background: #99a9bf;
    }
    .bg-purple {
        background: #d3dce6;
    }
    .bg-purple-light {
        background: #e5e9f2;
    }
    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }
    .row-bg {
        padding: 10px 0;
        background-color: #f9fafc;
    }
</style>

<body>


<div id="app">
    <br>
    <el-row :gutter="20">
        <el-col :span="4">&nbsp;</el-col>
        <el-col :span="16">
            <span class="demonstration">选择翻译文件：</span>
            <el-select v-model="input.root_path" placeholder="根路径" @change="_submit">
                <el-option
                        v-for="item in root_path"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                </el-option>
            </el-select>

            <el-select v-model="input.file_path" placeholder="翻译文件路径">
                <el-option
                        v-for="item in file_path"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                </el-option>
            </el-select>

            <el-select v-model="input.lang" placeholder="翻译语言">
                <el-option
                        v-for="item in lang"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                </el-option>
            </el-select>

            &nbsp; <el-button type="primary" @click="_submit">提交</el-button>
        </el-col>
        <el-col :span="4"></el-col>
    </el-row>

</div>

</body>
<script src="{{ asset('large/js/jquery.min.js') }}"></script>
<script src="{{ asset('large/layer/layer.js') }}"></script>
<script src="{{ asset('large/js/vue.js') }}"></script>
<script src="{{ asset('large/js/large.js') }}"></script>
<script src="{{ asset('large/js/index.js') }}"></script>



<script>
    Vue.prototype.$large = window.large

    var app = new Vue({
        el: '#app',
        data: {
            input:[],
            root_path: [
                {
                    value: 'routes',
                    label: 'routes'
                }, {
                    value: 'th',
                    label: '泰文'
                }, {
                    value: '',
                    label: '德语'
                }, {
                    value: 'jp',
                    label: '日本语'
                }, {
                    value: 'ara',
                    label: '阿拉伯'
                }],
            file_path: [],
            lang: [
            {
                value: 'en',
                label: '英文'
            }, {
                value: 'th',
                label: '泰文'
            }, {
                value: '',
                label: '德语'
            }, {
                value: 'jp',
                label: '日本语'
            }, {
                value: 'ara',
                label: '阿拉伯'
            }],
        },
        methods: {
            _submit() {
                var url = '/root_path/' + this.input.root_path
                this.$large.get(url, (res) => {
                    if (res.status == 'success') {
                        this.file_path = res.msg;
                    }else{
                        this.file_path = '';
                    }
                    return false;
                })
            },
            handleChange(value) {
                console.log(value);
            }
        },
    })
</script>

</html>

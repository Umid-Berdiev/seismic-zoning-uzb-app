import{q as d,c as i,v as u,i as m,g as t,u as e,W as c,e as _,t as f,m as p,f as a,G as w,l as g,j as y}from"./app.2776a0ac.js";import{_ as b}from"./Button.a880e3b5.js";import{_ as x}from"./GuestLayout.2b4ba958.js";import{_ as h}from"./Input.25b72b47.js";import{_ as k}from"./InputError.5155fc9a.js";import{_ as v}from"./InputLabel.ea37e2c4.js";const V=a("div",{class:"mb-4 text-sm text-gray-600"}," Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one. ",-1),N={key:0,class:"mb-4 font-medium text-sm text-green-600"},$=["onSubmit"],B={class:"flex items-center justify-end mt-4"},F=y(" Email Password Reset Link "),D={__name:"ForgotPassword",props:{status:String},setup(o){const s=d({email:""}),r=()=>{s.post(route("password.email"))};return(S,l)=>(i(),u(x,null,{default:m(()=>[t(e(c),{title:"Forgot Password"}),V,o.status?(i(),_("div",N,f(o.status),1)):p("",!0),a("form",{onSubmit:g(r,["prevent"])},[a("div",null,[t(v,{for:"email",value:"Email"}),t(h,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:e(s).email,"onUpdate:modelValue":l[0]||(l[0]=n=>e(s).email=n),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),t(k,{class:"mt-2",message:e(s).errors.email},null,8,["message"])]),a("div",B,[t(b,{class:w({"opacity-25":e(s).processing}),disabled:e(s).processing},{default:m(()=>[F]),_:1},8,["class","disabled"])])],40,$)]),_:1}))}};export{D as default};

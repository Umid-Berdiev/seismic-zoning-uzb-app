import{u as w,O as b,o as x,b as y,d as S,e as s,w as I,H as f,I as u,i as e,q as _,t as a,l as h,X as B}from"./app.ee5917d6.js";const V={class:"hero-static d-flex align-items-center"},k={class:"w-100"},M={class:"bg-body-extra-light"},j={class:"content content-full"},E={class:"row g-0 justify-content-center"},N={class:"col-md-8 col-lg-6 col-xl-4 py-4 px-4 px-lg-5"},D=B('<div class="text-center"><p class="mb-2"><i class="fa fa-2x fa-circle-notch text-primary"></i></p><h1 class="h4 mb-1">Sign In</h1><p class="fw-medium text-muted mb-3"> A perfect match for your project </p></div>',1),F=["onSubmit"],P={class:"py-3"},T={class:"mb-4"},U={class:"invalid-feedback animated fadeIn"},q={class:"mb-4"},z={class:"invalid-feedback animated fadeIn"},A=s("div",{class:"row justify-content-center"},[s("div",{class:"col-lg-6 col-xxl-5"},[s("button",{type:"submit",class:"btn w-100 btn-alt-primary"},[s("i",{class:"fa fa-fw fa-sign-in-alt me-1 opacity-50"}),h(" Kirish ")])])],-1),C={class:"fs-sm text-center text-muted py-3"},L={__name:"Login",props:{canResetPassword:Boolean,status:String},setup(H){const t=w({email:"",password:"",remember:!1}),n=b();x(()=>{document.getElementById("login-email").focus()});async function g(){t.post(route("login"),{onFinish:()=>t.reset("password")})}return(v,o)=>{var l,r,c,d,m,p;return y(),S("div",V,[s("div",k,[s("div",M,[s("div",j,[s("div",E,[s("div",N,[D,s("form",{onSubmit:I(g,["prevent"])},[s("div",P,[s("div",T,[f(s("input",{type:"text",class:_(["form-control form-control-lg form-control-alt",{"is-invalid":(r=(l=e(t).errors)==null?void 0:l.email)==null?void 0:r.length}]),id:"login-email",name:"login-email",placeholder:"Email","onUpdate:modelValue":o[0]||(o[0]=i=>e(t).email=i)},null,2),[[u,e(t).email]]),s("div",U,a((c=e(t).errors)==null?void 0:c.email),1)]),s("div",q,[f(s("input",{type:"password",class:_(["form-control form-control-lg form-control-alt",{"is-invalid":(m=(d=e(t).errors)==null?void 0:d.password)==null?void 0:m.length}]),id:"login-password",name:"login-password",placeholder:"Password","onUpdate:modelValue":o[1]||(o[1]=i=>e(t).password=i)},null,2),[[u,e(t).password]]),s("div",z,a((p=e(t).errors)==null?void 0:p.password),1)])]),A],40,F)])])])]),s("div",C,[s("strong",null,a(e(n).app.name),1),h(" \xA9 "+a(e(n).app.copyright),1)])])])}}};export{L as default};
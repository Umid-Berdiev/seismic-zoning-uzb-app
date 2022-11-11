import{p as w,c as g,e as x,G as r,u as t,B as v,Y as B,q as I,T as A,v as O,i as y,f as e,g as T,L as z,t as l,j as o,l as C,O as k,P as S}from"./app.6dbce729.js";import{_ as M}from"./GuestLayout.bd1b00d8.js";const N={__name:"BaseBackground",props:{image:{type:String,description:"The url of the image to show"},innerClass:{type:String,description:"The class of the inner div. Usually a background color with opacity class"},imageTop:{type:Boolean,default:!1,description:"Align the image background to the top"},imageBottom:{type:Boolean,default:!1,description:"Align the image background to the bottom"},imageFixed:{type:Boolean,default:!1,description:"Set the background to fixed for a parallax effect"}},setup(a){const s=a,n=w(()=>({"bg-image-top":s.imageTop,"bg-image-bottom":s.imageBottom,"bg-image-fixed":s.imageFixed})),c=w(()=>({[s.innerClass]:s.innerClass}));return(d,i)=>(g(),x("div",{style:B(a.image?`background-image: url('${a.image}');`:null),class:r([t(n),"bg-image"])},[a.innerClass?(g(),x("div",{key:0,class:r(t(c))},[v(d.$slots,"default")],2)):v(d.$slots,"default",{key:1})],6))}},V={class:"row g-0 bg-primary-dark-op"},j={class:"hero-static col-lg-7 d-none d-lg-flex flex-column justify-content-center"},E={class:"p-4 p-xl-5 flex-grow-1 d-flex align-items-center"},L={class:"w-100 text-center"},U=e("img",{src:"/images/uzbekistan-gerb.png",alt:"uzb_gerb",width:"100"},null,-1),F=e("br",null,null,-1),$=o(" O'ZBEKISTON RESPUBLIKASI FANLAR AKADEMIYASI "),D=e("br",null,null,-1),G=o(" G'.O.MAVLONOV NOMIDAGI SEYSMOLOGIYA INSTITUTI "),K={class:"p-4 p-xl-5 d-xl-flex justify-content-between align-items-center fs-sm"},P={class:"fw-medium text-white-50 mb-0"},Y={class:"hero-static col-lg-5 d-flex flex-column align-items-center bg-body-extra-light"},R={class:"p-4 w-100 flex-grow-1 d-flex align-items-center"},Z={class:"w-100"},q=e("div",{class:"text-center mb-5"},[e("img",{src:"/images/circle-cropped.png",alt:"main_logo",width:"100"}),e("br"),e("br"),e("h3",{class:"fw-bold mb-2"},[e("span",null,[o("Online Map \u201CSeismicZoningUzb\u201D "),e("br"),o(" elektron platformasi axborot tizimi")])]),e("h3",{class:"text-muted"},"Hush kelibsiz!")],-1),H={class:"row g-0 justify-content-center"},J={class:"col-sm-8 col-xl-6"},Q=["onSubmit"],W={class:"mb-4"},X={class:"invalid-feedback animated fadeIn"},ee={class:"mb-4"},se={class:"invalid-feedback animated fadeIn"},te=e("div",{class:"d-flex justify-content-between align-items-center mb-4"},[e("div",null,[e("button",{type:"submit",class:"btn btn-lg btn-alt-primary"},[e("i",{class:"fa fa-fw fa-sign-in-alt me-1 opacity-50"}),o(" Kirish ")])])],-1),oe={layout:M},ne=Object.assign(oe,{__name:"SignIn3View",props:{canResetPassword:Boolean,status:String},setup(a){const s=I({email:"",password:"",remember:!1}),n=A();async function c(){s.post(route("login"),{onFinish:()=>s.reset("password")})}return(d,i)=>(g(),O(N,{image:"/images/88.jpg"},{default:y(()=>{var p,f,u,_,h,b;return[e("div",V,[e("div",j,[e("div",E,[e("div",L,[U,F,T(t(z),{href:"#",class:"link-fx fw-semibold fs-2 text-white"},{default:y(()=>[$,D,G]),_:1})])]),e("div",K,[e("p",P,[e("strong",null,l(t(n).app.name),1),o(" \xA9 "+l(t(n).app.copyright),1)])])]),e("div",Y,[e("div",R,[e("div",Z,[q,e("div",H,[e("div",J,[e("form",{onSubmit:C(c,["prevent"])},[e("div",W,[k(e("input",{type:"text",class:r(["form-control form-control-lg form-control-alt",{"is-invalid":(f=(p=t(s).errors)==null?void 0:p.email)==null?void 0:f.length}]),id:"login-email",name:"login-email",placeholder:"Elektron manzil","onUpdate:modelValue":i[0]||(i[0]=m=>t(s).email=m)},null,2),[[S,t(s).email]]),e("div",X,l((u=t(s).errors)==null?void 0:u.email),1)]),e("div",ee,[k(e("input",{type:"password",class:r(["form-control form-control-lg form-control-alt",{"is-invalid":(h=(_=t(s).errors)==null?void 0:_.password)==null?void 0:h.length}]),id:"login-password",name:"login-password",placeholder:"Parol","onUpdate:modelValue":i[1]||(i[1]=m=>t(s).password=m)},null,2),[[S,t(s).password]]),e("div",se,l((b=t(s).errors)==null?void 0:b.password),1)]),te],40,Q)])])])])])])]}),_:1}))}});export{ne as default};
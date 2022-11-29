import{N as _,u as h,b as v,d as w,e as s,w as y,G as n,H as r,h as i,n as l,t as a,k as f,f as x,g as b,Z as q}from"./app.35649df7.js";import{_ as k}from"./BaseBlock.afe43d44.js";const D={class:"hero-static d-flex align-items-center"},V={class:"w-100"},C={class:"bg-body-extra-light"},S={class:"content content-full"},U={class:"row g-0 justify-content-center"},I={class:"col-md-8 col-lg-6 col-xl-4 py-4 px-4 px-lg-5"},N=q('<div class="text-center"><p class="mb-2"><i class="fa fa-2x fa-circle-notch text-primary"></i></p><h1 class="h4 mb-1">Create Account</h1><p class="text-muted mb-3"> Get your access today in one easy step </p></div>',1),B=["onSubmit"],M={class:"py-3"},T={class:"mb-4"},j={class:"invalid-feedback animated fadeIn"},A={class:"mb-4"},E={class:"invalid-feedback animated fadeIn"},F={class:"mb-4"},G={class:"invalid-feedback animated fadeIn"},P={class:"mb-4"},z={class:"invalid-feedback animated fadeIn"},H=s("div",{class:"row justify-content-center"},[s("div",{class:"col-lg-6 col-xxl-5"},[s("button",{type:"submit",class:"btn w-100 btn-alt-success"},[s("i",{class:"fa fa-fw fa-plus me-1 opacity-50"}),f(" Sign Up ")])])],-1),R={class:"fs-sm text-center text-muted py-3"},Z={class:"modal fade",id:"one-signup-terms",tabindex:"-1",role:"dialog","aria-labelledby":"one-signup-terms","aria-hidden":"true"},$={class:"modal-dialog modal-lg modal-dialog-popout",role:"document"},J={class:"modal-content"},K=s("button",{type:"button",class:"btn-block-option","data-bs-dismiss":"modal","aria-label":"Close"},[s("i",{class:"fa fa-fw fa-times"})],-1),L=s("div",{class:"block-content"},[s("p",null," Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi. "),s("p",null," Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi. "),s("p",null," Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi. "),s("p",null," Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi. "),s("p",null," Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi. "),s("p",null," Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi. ")],-1),O=s("div",{class:"block-content block-content-full text-end bg-body"},[s("button",{type:"button",class:"btn btn-sm btn-alt-secondary me-1","data-bs-dismiss":"modal"}," Close "),s("button",{type:"button",class:"btn btn-sm btn-primary","data-bs-dismiss":"modal"}," I Agree ")],-1),ss={__name:"Register",setup(Q){const u=_(),t=h({username:"",email:"",password:"",password_confirmation:"",terms:!1});async function g(){t.post(route("register"),{onFinish:()=>t.reset("password","password_confirmation")})}return(W,e)=>{var c,m,d,p;return v(),w("div",D,[s("div",V,[s("div",C,[s("div",S,[s("div",U,[s("div",I,[N,s("form",{onSubmit:y(g,["prevent"])},[s("div",M,[s("div",T,[n(s("input",{type:"text",class:l(["form-control form-control-lg form-control-alt",{"is-invalid":(c=i(t).errors.username)==null?void 0:c.length}]),id:"signup-username",name:"signup-username",placeholder:"Username","onUpdate:modelValue":e[0]||(e[0]=o=>i(t).username=o)},null,2),[[r,i(t).username]]),s("div",j,a(i(t).errors.username),1)]),s("div",A,[n(s("input",{type:"text",class:l(["form-control form-control-lg form-control-alt",{"is-invalid":(m=i(t).errors.email)==null?void 0:m.length}]),id:"signup-email",name:"signup-email",placeholder:"Email","onUpdate:modelValue":e[1]||(e[1]=o=>i(t).email=o)},null,2),[[r,i(t).email]]),s("div",E,a(i(t).errors.email),1)]),s("div",F,[n(s("input",{type:"password",class:l(["form-control form-control-lg form-control-alt",{"is-invalid":(d=i(t).errors.password)==null?void 0:d.length}]),id:"signup-password",name:"signup-password",placeholder:"Password","onUpdate:modelValue":e[2]||(e[2]=o=>i(t).password=o)},null,2),[[r,i(t).password]]),s("div",G,a(i(t).errors.password),1)]),s("div",P,[n(s("input",{type:"password",class:l(["form-control form-control-lg form-control-alt",{"is-invalid":(p=i(t).errors.password_confirmation)==null?void 0:p.length}]),id:"signup-password-confirm",name:"signup-password-confirm",placeholder:"Confirm Password","onUpdate:modelValue":e[3]||(e[3]=o=>i(t).password_confirmation=o)},null,2),[[r,i(t).password_confirmation]]),s("div",z,a(i(t).errors.password_confirmation),1)])]),H],40,B)])])])]),s("div",R,[s("strong",null,a(i(u).app.name),1),f(" \xA9 "+a(i(u).app.copyright),1)])]),s("div",Z,[s("div",$,[s("div",J,[x(k,{title:"Terms & Conditions",transparent:"",class:"mb-0"},{options:b(()=>[K]),content:b(()=>[L,O]),_:1})])])])])}}};export{ss as default};

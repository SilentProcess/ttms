#### How to install

fetch this folder to where you want to deploy  
install Node.js and NPM (9.2 preferably)  
after installation navigate to the the folder data-visualization  
after you should be able to run it simply by:
´´´
npm install
npm run
´´´
if it doesn't work by now, run ´´´npm install webpack´´´

this will debloy test version hosted locally  
to host it in internet you need to build it  
´´´
npm run build
´´´
this creates a build directory  
install a http server  
´´´
npm install -g serve
serve -s build
´´´
this will debloy a working built version on port 5000

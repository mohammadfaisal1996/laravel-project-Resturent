
const socket = require("socket.io-client")("localhost:3400");

socket.on("connect_error", (err) => {
  console.log(`connect_error due to ${err.message}`);
});






socket.on("hi",(data)=>{
    console.log(data);
})
const express = require("express");

const app = express();

const server = require("http").createServer(app);

const io = require("socket.io")(server, {
    handlePreflightRequest: (req, res) => {
        const headers = {
            "Access-Control-Allow-Headers": "*",
            "Access-Control-Allow-Origin": "*",
            "Access-Control-Allow-Credentials": true,
            "Access-Control-Allow-Methods": "PUT, GET, POST, DELETE, OPTIONS",
        };
        res.writeHead(200, headers);
        res.end();
    },
    cors: {
        origin: "*",
    },
});

io.on("connection", (socket) => {
    console.log("connection");

    socket.on("sendToStockServer", (message, id, companyId) => {
        console.log({
            id: id,
            message: message,
            server: "server.js",
            companyId: companyId,
        });
        io.emit("getStockServer", message, id, companyId);
    });

    socket.on("reminderServerSend", (message) => {
        io.emit("reminderServerListen", message);
    });

    socket.on("disconnect", (socket) => {
        console.log("Disconnect");
    });
});

server.listen(9699, () => {
    console.log("Server is running");
});





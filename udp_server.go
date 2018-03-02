package main

import (
    "fmt"
    "net"
	"time"
)

func main() {
    // 创建监听
    socket, err := net.ListenUDP("udp4", &net.UDPAddr{
        IP:   net.IPv4(192, 168, 182, 105),
        Port: 9998,
    })
    if err != nil {
        fmt.Println("监听失败!", err)
        return
    }
    defer socket.Close()

	var flag = 1

	starttime := time.Now().UnixNano()/1e6
	flagStop := 0

    for {
        // 读取数据
        data := make([]byte, 4096)
        _, remoteAddr, err := socket.ReadFromUDP(data)

        if err != nil {
            fmt.Println("读取数据失败!", err)
            continue
        }

		//fmt.Println(read, remoteAddr)
        //fmt.Printf("%s\n", data)



		if(flag == 1){
			starttime = time.Now().UnixNano()/1e6
		}

		if(time.Now().UnixNano()/1e6 - starttime >= 1000 && flagStop == 0){
					fmt.Printf("%d\n", flag)
					flagStop = 1
		}


		flag = flag + 1

        // 发送数据
        senddata := []byte("hello client!")
        _, err = socket.WriteToUDP(senddata, remoteAddr)
        if err != nil {
            return
            fmt.Println("发送数据失败!", err)
        }
    }
}

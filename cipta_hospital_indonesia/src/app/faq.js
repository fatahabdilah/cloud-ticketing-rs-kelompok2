"use client"

import { useState } from "react";

export default function FAQ(props){
    const [open,setOpen] = useState(false)
    return(
        <div className="text-black"> 
            <div onClick={()=>{setOpen(prev => !prev)}}>{props.question}{open ? "-" : "+"} </div>
            {open && <div>{props.children}</div>}
        </div>

    )
}
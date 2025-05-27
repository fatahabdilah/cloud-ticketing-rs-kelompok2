"use client"
import { BiLike } from "react-icons/bi";

function Thumbnail(){
    return(
        <img 
        src="https://i.ytimg.com/vi/7NB1Auof7_8/hqdefault.jpg?sqp=-oaymwEnCNACELwBSFryq4qpAxkIARUAAIhCGAHYAQHiAQoIGBACGAY4AUAB&rs=AOn4CLBK0AaTKUsiob0ZH2ho_usWVQpl6w" 
        alt="Thumbnail"
        onError={(e) => console.error("Gagal memuat gambar", e)}
        />
    );
    
}


export default function Video() {
  return (
    <div>
      <Thumbnail />
      <a 
      href={"https://www.youtube.com/watch?v=7NB1Auof7_8&ab_channel=OutdoorBoys"}
      onClick={(e)=> console.log("Link diklik",e)}
      >
        <h3>{"Outdoor Boys"}"</h3>
        <p>{"For 2 weeks we are exploring Florida's everglades, remote islands, and beautiful keys. Hunting alligators, catching pythons, crabbing, raking oysters, fishing, spear fishing, scuba diving, meeting up with friends and more."}</p>
      </a>
      <BiLike/>
    </div>
  );
}


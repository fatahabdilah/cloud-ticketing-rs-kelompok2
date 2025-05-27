import { GiHamburgerMenu } from "react-icons/gi";
import React from "react";



const Beranda = () => {
  return (
    <div className="font-[Poppins] bg-white overflow-x-hidden">
      {/* Navbar */}
      <nav className="sticky top-0 left-0 w-full bg-white flex justify-center h-[75px] shadow-md z-[100]">
        <div className="navbar flex items-center justify-between px-2 w-full max-w-[1300px] ">
          <div className="Logo flex items-center">
            <img src="Asset/logobgwhite.svg" alt="Logo" className="h-[50px] p-1.5" />
            <p className="text-[20px] font-[Poppins] text-black"></p>
          </div>
          <div className="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <ul className="flex items-center font-[Poppins] text-[16px] text-black">
              {["Beranda", "Tentang Kami", "Layanan"].map((item) => (
                <li key={item}>
                  <a
                    href={`#${item.replace(/\s+/g, "").toLowerCase()}`}
                    className="relative px-[15px] py-[10px] hover:after:w-full after:content-[''] after:absolute after:left-1/2 after:bottom-0 after:w-0 after:h-[2px] after:bg-[#054FA9] after:transition-all after:duration-300 after:ease-in-out after:-translate-x-1/2"
                  >
                    {item}
                  </a>
                </li>
              ))}
            </ul>
          </div>
          <GiHamburgerMenu className="text-black text-2xl" />
         
        </div>
      </nav>
      <div>
      </div>
      {/* Section 1 */}
      <section className="w-full bg-[#054FA91A] flex flex-col justify-center items-center">
        <div className="banneruser">
          <img src="Asset/Banner.png" alt="Banner" className="block" />
        </div>
        <div className="Logo2 h-[50px] flex items-center px-[5px] bg-[#054FA9] text-white font-semibold md:w-[250px] w-full justify-center md:rounded-b-[10px] rounded-b-[20px]">
          <img src="Asset/logobgblue.svg" alt="Logo2" className="h-[45px] p-[5px]" />
        </div>
      <p className="motto mt-[20px] mb-[20px] text-center text-black">
          Melayani dari Hati, Membangkitkan Harapan
        </p>
      </section>
      {/* Section 2 */}
      <section className="w-full bg-white flex justify-center items-center">
        <div className="items-center w-full flex-col flex md:flex-row p-10">
              <div className="judultentang text-black flex flex-col w-[100%]">
                <h1 className="text-2xl">Tentang Kami</h1>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a typenter took a galley of type and scrambled it of type and scrambled it to make a typenter took.</p>
              </div>
              <img src="Asset/hospitalbed.jpg" alt="kasur-rs" className="w-full md:w-[25%] rounded-xl " />
        </div>
      </section>
      {/* Section 3 */}
      <section className="bg-[#054FA91A] w-full">
        <div>
         <h1></h1>
         <p></p>
        </div>
      </section>
    </div>
  );
};
export default Beranda;

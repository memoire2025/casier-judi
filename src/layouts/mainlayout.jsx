import React from "react";
import MainDesign from "./../composants/header/header";

function MainLayout({children}) {
  return (
    <>
      <MainDesign>
        {children}
      </MainDesign>
    </>
  );
}

export default MainLayout;
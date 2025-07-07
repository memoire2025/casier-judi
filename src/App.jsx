import React from "react";
import { Routes, Route } from "react-router-dom";
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.min.js';
import './assets/font-awesome/css/all.min.css';
import './assets/css/index.css';

import MainLayout from "./layouts/mainlayout";
import AuthLayout from "./layouts/authlayout";
import Home from "./composants/pages/Home";
import Login from "./composants/pages/Login";
import Casier from "./composants/pages/Casier";
import InfoCasier from "./composants/pages/Infocasier";
import { Identification } from "./composants/pages/Infocasier";
import Infraction from "./composants/pages/infraction";
import Agent from "./composants/pages/Agent";
import NotFound from "./composants/pages/NotFound";

import PrivateRoute from "./composants/authent/verifAuth";
import TitleMgm from "./titlemgnger/titlemgmt";

function App() {
  return (
        <>
          <TitleMgm />
          <Routes>
            {['/', 'login'].map((path) => (
                <Route key={path} path={path} element={<AuthLayout><Login /></AuthLayout>} />
              ))}
        
            <Route element={<PrivateRoute/>}>
              {['/accueil', '/home'].map((path) => (
                <Route key={path} path={path} element={<MainLayout><Home /></MainLayout>} />
              ))}
              <Route path="/casier" element={<MainLayout><Casier/></MainLayout>} />
              <Route path="/infocasier" element={<MainLayout><InfoCasier/></MainLayout>} />
              <Route path="/indetification" element={<MainLayout><Identification /></MainLayout>} />
              <Route path="/infraction" element={<MainLayout><Infraction /></MainLayout>} />
              <Route path="/agent" element={<MainLayout><Agent /></MainLayout>} />
            </Route>
            
            <Route path="*" element={<NotFound />} />

          </Routes>
        </>  
  )
}

export default App;
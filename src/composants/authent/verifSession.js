import { Navigate, Outlet } from "react-router-dom";

const SessionMedecin = () => {
  const userInfo = localStorage.getItem("userInfo-casier");

  const session = JSON.parse(userInfo);

  return session.role === "MEDECIN" ? <Outlet /> : <Navigate to="/login" />;
};

export default SessionMedecin;
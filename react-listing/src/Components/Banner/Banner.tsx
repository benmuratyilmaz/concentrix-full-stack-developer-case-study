import "./Banner.css";
// import logo from "../../assets/logo.webp";

export default function Banner() {
  return (
    <aside className="banner">
      <header>
        <h1>We’re Concentrix.</h1>
        <h3>The intelligent transformation partner.</h3>
        <p>
          We help the world’s leading organizations to modernize technology,
          transform experiences, and solve their toughest business challenges
        </p>
        <a
          href="https://www.concentrix.com/"
          target="_blank"
          className="button"
        >
          Detail
        </a>
      </header>
    </aside>
  );
}

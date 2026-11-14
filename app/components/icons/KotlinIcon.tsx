export default function KotlinIcon({ size = 30, ...props }) {
  return (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 24 24"
      width={size}
      height={size}
      fill="#7F52FF"
      {...props}
    >
      <path d="M24 24H0V0h24L12 12Z" />
    </svg>
  );
}
